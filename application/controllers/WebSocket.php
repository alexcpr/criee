<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Serveur websocket permettant de rendre le système d'enchère synchrone
 */
class WebSocket extends CI_Controller implements MessageComponentInterface
{
    /**
     * Liste de tous les utilisateurs connectés au websocket
     * @var 
     */
    private $clients;

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('encheres');
        $this->clients = new SplObjectStorage();
    }

    /**
     * Fonction de démarrage du serveur
     * @return void
     */
    public function index()
    {
        // on tente de démarrer le serveur sur le port 8282
        try {
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        $this
                    )
                ),
                8282
            );
            $server->run();
        } catch (\Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

    /**
     * Événement déclenché lors de la fermeture de la connexion entre le client et le websocket
     * @param Ratchet\ConnectionInterface $conn
     * @return void
     */
    public function onClose(ConnectionInterface $conn)
    {
        // suppression de l'utilisateur de la liste des utilisateurs connectés au websocket
        $this->clients->detach($conn);

        echo "Déconnexion de: {$conn->resourceId}\n";
    }

    /**
     * Événement déclenché lors d'une nouvelle connexion au websocket
     * @param Ratchet\ConnectionInterface $conn
     * @return void
     */
    public function onOpen(ConnectionInterface $conn)
    {
        // on récupère les paramètres passés lors de la connexion au websocket
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $params);

        // on vérifie qu'ils sont tous présent
        if (isset($params['id'], $params['idBateau'], $params['idDatePeche'], $params['userId'], $params['token'])) {
            $enchereId = $params['id'];
            $bateauId = $params['idBateau'];
            $datePecheId = $params['idDatePeche'];
            $userId = $params['userId'];
            $token = $params['token'];

            // on rattache la valeur des paramètres du websocket à l'utilisateur
            // ici pour détecter sur quel enchère il se situe
            $conn->enchereId = $enchereId;
            $conn->bateauId = $bateauId;
            $conn->datePecheId = $datePecheId;

            // ici pour savoir qui est l'utilisateur ainsi que son jeton
            $conn->userId = $userId;
            $conn->token = $token;

            // ajout de l'utilisateur à la liste des utilisateur connectés
            $this->clients->attach($conn);

            echo "Nouvelle connexion: {$conn->resourceId}\n";
        } else {
            // fermeture de la connexion si tout les paramètres ne sont pas présents
            $conn->close();
        }
    }

    /**
     * Événement déclenché lorsqu'une requête est envoyée au websocket
     * @param Ratchet\ConnectionInterface $from
     * @param mixed $msg
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        // on décode les données qui ont était transmise lors de la requête au format JSON
        $data = json_decode($msg, true);

        // ici on récupère les données qui ont était rattachée à l'utilisateur
        $enchereId = $from->enchereId;
        $bateauId = $from->bateauId;
        $datePecheId = $from->datePecheId;
        $userId = $from->userId;
        $token = $from->token;

        // on vérifie si le jeton est valide pour le user id 
        if ($this->verifToken($token, $userId)) {
            // on vérifie que l'enchère auquel l'utilisateur est rattachée correspond à celle concernée par la requête
            if ($enchereId === $data['id'] && $bateauId === $data['idBateau'] && $datePecheId === $data['idDatePeche'] && !empty($data['captcha'])) {
                // vérification du captcha
                $recaptcha = new \ReCaptcha\ReCaptcha($this->config->item('recaptcha_secret_key'));
                $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
                    ->verify($data['captcha'], $_SERVER['REMOTE_ADDR']);
                // si le captcha est valide
                if ($resp->isSuccess()) {
                    // on tente d'enregistrer l'enchère dans la base de données en appellant le modèle et en lui passant les paramètres nécessaires
                    try {
                        $result = $this->encheres->encherir(
                            $userId,
                            $data['id'],
                            $data['idBateau'],
                            $data['idDatePeche'],
                            $data['bidAmount']
                        );

                        // on envoie une mise à jour à tout les utilisateurs connectés au websocket
                        foreach ($this->clients as $client) {
                            // les utilisateurs reçoivent la mise à jour seulement s'ils sont sur la même enchère que celle qui à obtenu une nouvelle enchère
                            if ($enchereId === $client->enchereId && $bateauId === $client->bateauId && $datePecheId === $client->datePecheId) {
                                // ici on gère la mise à jour pour celui qui a envoyé la requête
                                if ($from == $client) {
                                    // s'il n'y à pas d'erreur lors de l'enregistrement de l'enchère, on transmet aux utilisateurs
                                    // -> le prénom + la première lettre du nom de celui viens d'enchérir
                                    // -> un message de succès disant que son enchère à était enregistré avec succès
                                    // -> la nouvelle enchère
                                    if (strpos($result, 'error') === false) {
                                        $client->send(
                                            json_encode(
                                                array(
                                                    'newEnchere' => number_format((float) $data['bidAmount'], 2, '.', ''),
                                                    'dernierEncheri' => $this->encheres->getDernierEncheri($data['id'], $data['idBateau'], $data['idDatePeche']),
                                                    'result' => $result,
                                                    'error' => false
                                                )
                                            ));
                                    } else {
                                        // si une erreur est survenue lors de l'enregistrement de l'enchère on l'affiche à l'utilisateur
                                        $client->send(
                                            json_encode(
                                                array(
                                                    'result' => $result,
                                                    'error' => true
                                                )
                                            ));
                                    }
                                } else {
                                    // et ici pour tout le reste des utilisateurs
                                    // s'il n'y à pas d'erreur lors de l'enregistrement de l'enchère, on transmet aux utilisateurs
                                    // -> le prénom + la première lettre du nom de celui viens d'enchérir
                                    // -> un message d'information que prénom + première lettre du nom viens d'enchérir
                                    // -> la nouvelle enchère
                                    if (strpos($result, 'error') === false) {
                                        $dernierEncheri = $this->encheres->getDernierEncheri($data['id'], $data['idBateau'], $data['idDatePeche']);
                                        $client->send(
                                            json_encode(
                                                array(
                                                    'newEnchere' => number_format((float) $data['bidAmount'], 2, '.', ''),
                                                    'dernierEncheri' => $dernierEncheri,
                                                    'error' => false,
                                                    'result' => '
                                            <div class="info-msg">
                                                <i class="fa-solid fa-circle-info"></i> ' . $dernierEncheri . ' vient de surenchérir!
                                            </div>'
                                                )
                                            ));
                                    }
                                }
                            }
                        }
                    } catch (Exception $e) {
                        // si la requête à la base de données à échoué on affiche un message d'erreur à celui qui a tenté d'enchérir
                        foreach ($this->clients as $client) {
                            if ($from == $client) {
                                $client->send(
                                    json_encode(
                                        array(
                                            'result' => '
                                    <div class="error-msg">
                                        <i class="fa-solid fa-x"></i> Erreur!
                                        <br>
                                        Une erreur inattendue s\'est produite.
                                        <br>
                                        Veuillez réessayer.
                                    </div>
                                    ',
                                            'error' => true
                                        )
                                    ));
                            }
                        }
                    }
                } else {
                    // l'utilisateur essayant d'enchérir à "trafiqué" le captcha
                    foreach ($this->clients as $client) {
                        if ($from == $client) {
                            $client->send(
                                json_encode(
                                    array(
                                        'result' => '
                                <div class="error-msg">
                                    <i class="fa-solid fa-x"></i> Nope!
                                    <br>
                                    Bien tenté ;)
                                </div>
                                ',
                                        'error' => true
                                    )
                                ));
                        }
                    }
                }
            } else {
                // l'utilisateur essayant d'enchérir à "trafiqué" les paramètres passées au websocket
                foreach ($this->clients as $client) {
                    if ($from == $client) {
                        $client->send(
                            json_encode(
                                array(
                                    'result' => '
                            <div class="error-msg">
                                <i class="fa-solid fa-x"></i> Nope!
                                <br>
                                Bien tenté ;)
                            </div>
                            ',
                                    'error' => true
                                )
                            ));
                    }
                }
            }
        } else {
            // l'utilisateur essayant d'enchérir à "trafiqué" l'user id surement pour but d'essayer d'enchérir en tant qu'un autre utilisateur
            foreach ($this->clients as $client) {
                if ($from == $client) {
                    $client->send(
                        json_encode(
                            array(
                                'result' => '
                        <div class="error-msg">
                            <i class="fa-solid fa-x"></i> Nope!
                            <br>
                            Bien tenté ;)
                        </div>
                        ',
                                'error' => true
                            )
                        ));
                }
            }
        }

    }

    /**
     * Événement déclenché lorsqu'une erreur se produit
     * @param Ratchet\ConnectionInterface $conn
     * @param Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Une erreur s'est produite: {$e->getMessage()}\n";
        $conn->close();
    }

    /**
     * Permet de vérifier si le jeton est valide
     * @param mixed $token
     * @param mixed $user_id
     * @return bool
     */
    private function verifToken($token, $user_id)
    {
        $hash = hash('sha256', $user_id);
        return $token === $hash;
    }

}
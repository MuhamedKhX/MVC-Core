<?php


namespace muhamex\phpmvc;

class Application
{
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public ?DbModel $user = null;
    public Database $db;
    public static Application $app;

    public function __construct(array $config)
    {
        self::$app = $this;
        $this->userClass = $config['userClass'];
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();

        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if($primaryValue)
        {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }

    }

    public static function Guest()
    {
        return !self::$app->user;
    }

    public function run()
    {
        try {
            $this->router->resolve();
        } catch (\Exception $e)
        {
            echo "<h1>" . $e->getMessage() . "</h1>";
        }
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}
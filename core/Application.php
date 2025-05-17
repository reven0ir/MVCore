<?php

namespace MVCore;

class Application
{
    public string $uri;
    public Request $request;
    public Response $response;
    public Router $router;
    public View $view;
    public Database $db;
    public static Application $app;


    public function __construct()
    {
        self::$app = $this;
        $this->uri = $_SERVER['QUERY_STRING'];
        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View(LAYOUT);
        $this->db = new Database();
    }

    public function run(): void
    {
        echo $this->router->dispatch();
    }
}
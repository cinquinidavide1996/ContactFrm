<?php

class RoutingManager {

    private $route;
    private $version;
    private $httpMethod;
    private $routeFileCtrl;

    public function __construct(string $route, string $httpMethod) {
        $this->route = explode("/", $route);
        $this->httpMethod = $httpMethod;

        $this->setVersion();
        $this->setRoute();

        $this->routeFileCtrl = new RouteFileManager($this->version);
    }

    private function setVersion() {
        $this->version = $this->route[1];
    }

    private function setRoute() {
        array_shift($this->route);
        array_shift($this->route);
    }

    public function getRouteDetail(): array {
        return $this->routeFileCtrl->search($this->route, $this->httpMethod);
    }

    public function getVersion(): string {
        return $this->version;
    }

}

class RouteFileManager {

    private $content;
    private $path;
    private $version;

    public function __construct(string $v) {
        $this->version = $v;
        $this->path = __DIR__ . "/../../$this->version/route.json";
        $this->content = file_get_contents($this->path);
        $this->content = json_decode($this->content, true);
    }

    public function search(array $route, string $httpMethod): array {
        if (!isset($this->content[$httpMethod])) {
            throw new Exception("unexpected http method in route file.", CODE::INTERNALSERVERERROR);
        }

        foreach ($this->content[$httpMethod] as $k => $v) {
            $seeRoute = explode('/', $k);
            if ($this->isCurrentRoute($route, $seeRoute)) {
                return [
                    'route' => $v,
                    'param' => $this->getRouteParam($route, $seeRoute)
                ];
            }
        }


        foreach (glob(__DIR__ . "/../../$this->version/controllers/*.php") as $filename) {
            include_once $filename;
            $explosesFilename = explode('/', $filename);
            $current_class = substr(end($explosesFilename), 0, -4);

            foreach (get_class_methods($current_class) as $k => $v) {
                $class_method = $v;
                $ref = new ReflectionMethod($current_class, $v);
                $comment = $ref->getDocComment();

                $comment = str_replace('/*', '', $comment);
                $comment = str_replace('*/', '', $comment);
                $comment = str_replace('*', '', $comment);
                $comment = trim($comment);

                $result = explode('@', $comment);
                array_shift($result);
                $r = [];
                foreach ($result as &$v) {
                    $v = trim($v);
                    $app = explode(' ', $v);
                    $r[$app[0]] = $app[1];
                }

                if (isset($r['uri_path']) || isset($r['method'])) {
                    $expld = explode('/', $r['uri_path']);
                    array_shift($expld);


                    if ($httpMethod === $r['method'] && $this->isCurrentRoute($route, $expld)) {

//                        $this->updateRouteFile($httpMethod, substr($r['uri_path'], 1), [
//                            'class' => "/controllers/$current_class.php",
//                            'method' => $class_method
//                        ]);

                        return [
                            'route' => [
                                'class' => "/controllers/$current_class.php",
                                'method' => $class_method
                            ],
                            'param' => $this->getRouteParam($route, $expld)
                        ];
                    }
                }
            }
        }

        throw new Exception("route not valid", CODE::INTERNALSERVERERROR);
    }

    public function updateRouteFile(string $http, string $route, array $v) {
        $this->content[$http][$route] = $v;
        file_put_contents($this->path, json_encode($this->content));
    }

    private function isCurrentRoute(array $current, array $see): bool {
        if (count($current) !== count($see)) {
            return false;
        }
        
        foreach ($see as $k => $v) {
            if (($v[0] !== ':') && $v !== $current[$k]) {
                return false;
            }
        }

        return true;
    }

    private function getRouteParam(array $current, array $see): array {
        $result = [];

        foreach ($see as $k => $v) {
            if ($v[0] === ':') {
                $result[$v] = $current[$k];
            }
        }

        return $result;
    }

}

class CommentRouting {

    private $version;
    private $autoloadCtrl;

    public function __construct($version) {
        $this->version = $version;
        $this->autoloadCtrl = new AutoloadManager();
    }

    private function interpretateComment(string $comment): array {
        $comment = str_replace('/*', '', $comment);
        $comment = str_replace('*/', '', $comment);
        $comment = str_replace('*', '', $comment);
        $comment = trim($comment);

        $commentArray = explode('@', $comment);
        
        if (trim($commentArray[0]) === '') {
            array_shift($commentArray);
        }
        
        $result = [];
        foreach ($commentArray as &$v) {
            $v = trim($v);
            $app = explode(' ', $v);
            $result[$app[0]] = $app[1];
        }
        
        return $result;
    }

}

//il RoutingFileManager deve avere:
    //check se una rotta esiste                 
    //prendere le informazioni di una rotta     
    //creare le informazioni di una rotta       
    //prendere lista delle rotte                
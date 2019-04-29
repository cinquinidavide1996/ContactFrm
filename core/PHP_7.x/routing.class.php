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
        $this->routeFileCtrl->updateRouteFile('GET', '', [
            'class' => 'test',
            'method' => 'test'
        ]);
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

    public function __construct(string $v) {
        $this->path = __DIR__ . "/../../$v/route.json";
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
            if ($v[0] !== ':' && $v !== $current[$k]) {
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


//il RoutingFileManager deve avere:
    //check se una rotta esiste                 
    //prendere le informazioni di una rotta     
    //creare le informazioni di una rotta       
    //prendere lista delle rotte                
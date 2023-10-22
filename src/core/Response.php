<?php

namespace AllanRezende\AppMercado\Core;
use AllanRezende\AppMercado\Views\NotFoundView;

class Response {
    private function setStatusCode(int $code): void {
        http_response_code($code);
    }

    public function notFound(): void {
        $this->setStatusCode(404);
        $notFoundView = new NotFoundView();
        echo $notFoundView->render();
    }

    public function send(string $html): void {
        echo $html;
    }

    public function json(array $data): void {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    public function redirect(string $path, array $params = []): void {
        $data = empty($params) ? "" : "?" . http_build_query($params);
        header("Location: " . $path . $data );
        exit();
    }

    public function noContent(): void {
        $this->setStatusCode(204);
    }
}
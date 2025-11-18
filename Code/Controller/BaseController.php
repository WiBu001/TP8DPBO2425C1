<?php
abstract class BaseController {

    protected function render($view, $data = []) {
        extract($data);

        include "View/{$view}.php";
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
}
?>

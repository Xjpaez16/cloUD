<?php
    class RouteController extends Controller {
        public function index() {
            $this->view('home');
        }
        public function materials() {
            $this->view('materials');
        }
    }
?>
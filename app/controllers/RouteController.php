<?php
    class RouteController extends Controller {
        public function index() {
            $this->view('home');
        }
        public function materials() {
            $this->view('materials');
        }
        public function login() {
        $this->view('login'); // muestra la vista login.php
        }
        public function register() {
            $this->view('register'); // muestra la vista login.php
        }
        public function studentregister() {
            $this->view('studentregister'); // muestra la vista login.php
        }
        }
?>
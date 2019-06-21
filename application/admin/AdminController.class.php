<?php

class AdminController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {

        return [
            'title' => "Accueil - Dashboard",
            'active' => "home",
        ];
		
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
    
    }
}
<?php

    function verificarSesion() 
    {
        if (empty($_SESSION)) 
        {
            header("Location: index.php?action=Principal");
            exit;
        }
    }


    function permisoAdministardor()
    {
        verificarSesion();
        if ($_SESSION['rol'] == 2) 
        {
            header("Location: index.php?action=vistaEmple");
            exit;
        }
    }
    

    function permisoEmpleado()
    {
        verificarSesion();
        

        if ($_SESSION['rol'] == 1) 
        {
            header("Location: index.php?action=vistaAdmin");
            exit;
        }
    }
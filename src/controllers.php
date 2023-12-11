<?php

/**
 * ResultsDoctrine - controllers.php
 *
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

use MiW\Results\Entity\User;
use MiW\Results\Entity\Result;
use MiW\Results\Utility\DoctrineConnector;

function funcionHomePage(): void
{
    global $routes;

    $rutaListadoUsuarios = $routes->get('ruta_user_list')->getPath();
    $rutaListadoResultados = $routes->get('ruta_result_list')->getPath();
    $formReadUser = $routes->get('ruta_read_user_form')->getPath();
    $formCreateUser = $routes->get('ruta_create_user_form')->getPath();
    $formDeleteUser = $routes->get('ruta_delete_user_form')->getPath();
    $formUpdateUser = $routes->get('ruta_update_user_form')->getPath();
    echo <<< MARCA_FIN
    <h3>Listas de datos</h3>
    <ul>
        <li><a href="$rutaListadoUsuarios">Listado Usuarios</a></li>
        <li><a href="$rutaListadoResultados">Listado Resultados</a></li>
    </ul>
    <h3>Formularios</h3>
    <h4>Usuarios</h4>
    <ul>
        <li><a href="$formReadUser">Leer</a></li>
        <li><a href="$formCreateUser">Crear</a></li>
        <li><a href="$formDeleteUser">Borrar</a></li>
        <li><a href="$formUpdateUser">Actualizar</a></li>
    </ul>

    MARCA_FIN;
}

function funcionListadoUsuarios(): void
{
    $entityManager = DoctrineConnector::getEntityManager();

    $userRepository = $entityManager->getRepository(User::class);
    $users = $userRepository->findAll();
    $usersText = "<ul>";
    foreach ($users as $user) {
        $jsonUser = json_encode($user->jsonSerialize(), JSON_PRETTY_PRINT);
        $usersText = $usersText . "<li>$jsonUser</li>";
    }
    $usersText = $usersText . "<ul>";
    echo $usersText;
}

function funcionListadoResultados(): void
{
    $entityManager = DoctrineConnector::getEntityManager();

    $resultsRepository = $entityManager->getRepository(Result::class);
    $results = $resultsRepository->findAll();
    $resultsText = "<ul>";
    foreach ($results as $result) {
        $jsonUser = json_encode($result->jsonSerialize(), JSON_PRETTY_PRINT);
        $resultsText = $resultsText . "<li>$jsonUser</li>";
    }
    $resultsText = $resultsText . "<ul>";
    echo $resultsText;
}

function funcionUsuario(string $name): void
{
    echo $name;
}

function funcionReadUserForm(): void
{
    require_once 'views/user/read_user.php';
}

function funcionCreateUserForm(): void
{
    require_once 'views/user/create_user.php';
}

function funcionDeleteUserForm(): void
{
    require_once 'views/user/delete_user.php';
}

function funcionUpdateUserForm(): void
{
    require_once 'views/user/update_user.php';
}

function funcionReadResultForm(): void
{
    require_once 'views/result/read_result.php';
}

function funcionCreateResultForm(): void
{
    require_once 'views/result/create_result.php';
}

function funcionDeletedResultForm(): void
{
    require_once 'views/result/read_result.php';
}

function funcionUpdateResultForm(): void
{
    require_once 'views/result/read_result.php';
}
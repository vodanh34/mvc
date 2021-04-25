<?php

declare(strict_types=1);

namespace Mos\Router;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url,
    cpuRoll
};

/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "Index page",
                "message" => "Hello, this is the index page, rendered as a layout.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/game21") {
            $data = [
                "processDice" => url("/game21/diceprocess"),
                "processRoll" => url("/game21/rollprocess"),
                "processStop" => url("/game21/stopprocess"),
                "processNext" => url("/game21/nextprocess"),
                "processWipe" => url("/game21/wipeprocess"),
                "output" => $_SESSION["output"] ?? null,
            ];
            $body = renderView("layout/game21.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "POST" && $path === "/game21/diceprocess") {
            $_SESSION["diceAmount"] = $_POST["content"] ?? null;
            $_SESSION["active"] = true;
            redirectTo(url("/game21"));
            return;
        } else if ($method === "POST" && $path === "/game21/rollprocess") {
            $_SESSION["dice"]->roll();
            $_SESSION["rolledDice"] = $_SESSION["dice"]->values();
            if (!isset($_SESSION["rolledDiceSum"])) {
                $_SESSION["rolledDiceSum"] = $_SESSION["dice"]->sum();
            } else {
                $_SESSION["rolledDiceSum"] += $_SESSION["dice"]->sum();
            }
            if ($_SESSION["rolledDiceSum"] > 21) {
                cpuRoll();
            }
            redirectTo(url("/game21"));
            return;
        } else if ($method === "POST" && $path === "/game21/stopprocess") {
            cpuRoll();
            redirectTo(url("/game21"));
            return;
        } else if ($method === "POST" && $path === "/game21/nextprocess") {
            $_SESSION["rolledDiceSum"] = null;
            $_SESSION["cpuRoll"] = null;
            $_SESSION["stop"] = null;
            $_SESSION["rolledDice"] = null;
            redirectTo(url("/game21"));
            return;
        } else if ($method === "POST" && $path === "/game21/wipeprocess") {
            destroySession();
            redirectTo(url("/game21"));
            return;
        } else if ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } else if ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/form/view") {
            $data = [
                "header" => "Form",
                "message" => "Press submit to send the message to the result page.",
                "action" => url("/form/process"),
                "output" => $_SESSION["output"] ?? null,
            ];
            $body = renderView("layout/form.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "POST" && $path === "/form/process") {
            $_SESSION["output"] = $_POST["content"] ?? null;
            redirectTo(url("/form/view"));
            return;
        }

        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}

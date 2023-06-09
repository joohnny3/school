<?php
require_once "db.php";
include_once "sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" href="./photo/hello.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>hi_School</title>
    <style>
        body {
            background-image: url(./photo/index.jpg);
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: auto;
            background-repeat: no-repeat;
        }

        #sidebar {
            position: fixed;
            left: -230px;
            top: 0;
            width: 230px;
            height: 100vh;
            overflow-y: auto;
            background-color: #0c0c0c9e;
            transition: all 0.5s;
        }


        #sidebar-button-wrapper {
            position: fixed;
            left: 8px;
            top: 5px;
            transition: all 0.5s;
            border: none;
        }

        .btn-link {
            text-decoration: none;
            --bs-btn-color: #f8f9fa;
            font-size: 18px;
        }

        .btn-link:hover {
            color: #f8f9fa;
        }

        .signOut>a {
            display: none;
        }


        .control-center {
            -webkit-filter: invert(100%);
            filter: invert(100%);
            transform: scale(0.5);
        }


        .dock {
            width: auto;
            height: 60px;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .dock-container {
            padding: 5px;
            width: auto;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            background: rgba(83, 83, 83, 0.25);
            backdrop-filter: blur(13px);
            -webkit-backdrop-filter: blur(13px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .li-bin {
            margin-left: 20px;
            border-left: 1.5px solid rgba(255, 255, 255, 0.4);
            padding: 0px 10px;
        }

        .li-1::after {
            position: absolute;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            content: "";
            bottom: 2px;
        }


        li {
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            vertical-align: bottom;
            transition: 0.2s;
            transform-origin: 50% 100%;
        }

        li:hover {
            margin: 0px 13px 0px 13px;
        }

        .ico {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.2s;
        }

        .bLogout>a {
            text-decoration: none;
            font-size: 18px;
        }

        #adFull>img {
            width: 100vw !important;
            height: 100vh !important;
        }

        #adFull {
            position: fixed;
            text-align: center;
            z-index: 9999;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .back>a{
            display: none;
        }
    </style>
</head>

<body>
    <div id="adFull">
        <img src="./photo/teacher.png" id="adImage">
    </div>
    <form id="myForm" action="./backend.php?do=student" method="post">
        <input type="hidden" name="school_num" id="school_num">
        <div class="dock">
            <div class="dock-container">
                <?php for ($i = 0; $i < count($_SESSION['school_nums']); $i++) { ?>
                    <li class="li-<?= $i + 1; ?>">
                        <div class="name"></div>
                        <img style="border-radius: 2px;padding: 0 2px;" class="ico" src="./image/<?= $_SESSION['school_imgs'][$i]; ?>" data-value="<?= $_SESSION['school_nums'][$i]; ?>">
                    </li>
                <?php }; ?>
            </div>
        </div>
    </form>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var buttonWrapper = document.getElementById('sidebar-button-wrapper');
            if (sidebar.style.left === '0px') {
                sidebar.style.left = '-230px';
                buttonWrapper.style.left = '0px';
            } else {
                sidebar.style.left = '0px';
                buttonWrapper.style.left = '230px';
            }
        }
        const adclose = document.querySelector("#adFull");

        adclose.addEventListener('click', () => {
            adclose.style.display = "none";
        });

        function findCook(name) {
            var ckary = document.cookie.split("; ");
            var getck = ckary.find(function(e) {
                return name == e.substr(0, name.length);
            });
            if (getck != undefined) return getck.split("=")[1];
            else return false;
        }
        var eatCook = findCook("watchedAd");
        if (!eatCook) {
            var end = new Date();
            end.setHours(23), end.setMinutes(59), end.setSeconds(59);
            document.cookie = "watchedAd=yes;expires=" + end.toUTCString();
        } else document.getElementById("adFull").remove();

        const images = document.querySelectorAll('.ico');
        for (let i = 0; i < images.length; i++) {
            images[i].addEventListener('click', function() {
                const val = this.getAttribute('data-value');
                document.querySelector('#school_num').value = val;
                document.querySelector('#myForm').submit();
            });
        }
        let icons = document.querySelectorAll(".ico");
        let length = icons.length;

        icons.forEach((item, index) => {
            item.addEventListener("mouseover", (e) => {
                focus(e.target, index);
            });
            item.addEventListener("mouseleave", (e) => {
                icons.forEach((item) => {
                    item.style.transform = "scale(1)  translateY(0px)";
                });
            });
        });

        const focus = (elem, index) => {
            let previous = index - 1;
            let previous1 = index - 2;
            let next = index + 1;
            let next2 = index + 2;

            if (previous == -1) {
                console.log("first element");
                elem.style.transform = "scale(1.5)  translateY(-10px)";
            } else if (next == icons.length) {
                elem.style.transform = "scale(1.5)  translateY(-10px)";
                console.log("last element");
            } else {
                elem.style.transform = "scale(1.5)  translateY(-10px)";
                icons[previous].style.transform = "scale(1.2) translateY(-6px)";
                icons[previous1].style.transform = "scale(1.1)";
                icons[next].style.transform = "scale(1.2) translateY(-6px)";
                icons[next2].style.transform = "scale(1.1)";
            }
        };
    </script>
    <?php

    $showSidebar = 0;
    $do = $_GET['do'] ?? '';
    $file = "./front/" . $do . ".php";
    $fileBack = "./back/" . $do . ".php";

    if (file_exists($file)) {
        include $file;
    } elseif (file_exists($fileBack)) {
        include $fileBack;
    }
    ?>
</body>


</html>
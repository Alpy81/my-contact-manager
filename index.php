<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gowun+Dodum&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="menubar">
        <h1>My Contact Book</h1>

        <div class="myname">
            <div class="avatar">J</div>Junus Ergin
        </div>
    </div>
    <div class="main">
        <div class="menu">
            <a href="index.php?page=start"><img src="img/home.svg"> Start</a>
            <a href="index.php?page=contacts"><img src="img/book.svg"> Kontakte</a>
            <a href="index.php?page=addcontact"><img src="img/add.svg"> Kontakt hinzufügen</a>
            <a href="index.php?page=legal"><img src="img/legal.svg"> Impressum</a>
        </div>





        <div class="content">


            <?php
            $headline = 'Herzlich willkommen';
            $contacts = [];

            if (file_exists('contacts.txt')) {
                $text = file_get_contents('contacts.txt', true);
                $contacts = json_decode($text, true);
            }


            if (isset($_POST['name']) && isset($_POST['phone'])) {
                echo 'Kontakt <b>' . $_POST['name'] . '</b> wurde hinzugefügt';
                $newContact = [
                    'name' => $_POST['name'],
                    'phone' => $_POST['phone']
                ];
                array_push($contacts, $newContact);
                file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
            }

            if ($_GET['page'] == 'delete') {
                $headline = 'Kontakt gelöscht';
            }

            if ($_GET['page'] == 'contacts') {
                $headline = 'Deine Kontakte';
            }

            if ($_GET['page'] == 'addcontact') {
                $headline = 'Kontakt hinzufügen';
            }

            if ($_GET['page'] == 'legal') {
                $headline = 'Impressum';
            }

            echo '<h1>' . $headline . '</h1>';

            if ($_GET['page'] == 'delete') {
                echo '<p>Dein Kontakt wurde gelöscht</p>';
                # Lade die Nummer der Reihe aus den URL Parametern
                $index = $_GET['delete']; 

                # Lösche die Stelle aus dem Array 
                unset($contacts[$index]); 

                # Tabelle erneut speichern in Datei contacts.txt
                file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
            } else if ($_GET['page'] == 'contacts') {
                echo "
                    <p>Auf dieser Seite hast du einen Überblick über deine <b>Kontakte</b></p>
                ";

                foreach ($contacts as $index=>$row) {
                    $name = $row['name'];
                    $phone = $row['phone'];

                    echo "
                    <div class='card'>
                        <img class='profile-picture' src='img/profile-picture.png'>
                        <b>$name</b><br>
                        $phone

                        <a class='phonebtn' href='tel:$phone'>Anrufen</a>
                        <a class='deletebtn' href='?page=delete&delete=$index'>Löschen</a>
                    </div>
                    ";
                }
            } else if ($_GET['page'] == 'legal') {
                echo "
                    Hier kommt das Impressum hin
                ";
            } else if ($_GET['page'] == 'addcontact') {
                echo "
                    <div>
                        Auf dieser Seite kannst du einen weiteren Kontakt hinzufügen
                    </div>
                    <form action='?page=contacts' method='POST'>
                        <div>
                            <input placeholder='Name eingeben' name='name'>
                        </div>
                        <div>
                            <input placeholder='Telefonnummer eingeben' name='phone'> 
                        </div>
                        <button type='Submit'>Absenden</button>
                    </form>
                ";
            } else {
                echo 'Du bist auf der Startseite!';
            }
            ?>
        </div>
    </div>

    <div class="footer">
        (C) 2021 Developer Akademie GmbH
    </div>
</body>

</html>
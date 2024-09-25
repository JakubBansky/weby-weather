<?php
$method = $_SERVER['REQUEST_METHOD'];
$ipAddress = $_SERVER['REMOTE_ADDR'];

$hashedIP = hash('sha256', $ipAddress);

$data = json_decode(file_get_contents('ip.json'), true);

date_default_timezone_set('Europe/Bratislava');
$hour = date('G'); 

if ($hour >= 6 && $hour < 15) {
    $timeZone = "1";
} elseif ($hour >= 15 && $hour < 21) {
    $timeZone = "2";
} elseif ($hour >= 21 || $hour < 24) {
    $timeZone = "3";
} else {
    $timeZone = "4";
}

$timestamp = time(); 
$currentTime = date('Y-m-d H:i:s', $timestamp);
$isNewVisitor = true;

foreach ($data[$timeZone] as $visitor) {
    $visitorTimestamp = strtotime($visitor['timestamp']); 


    $oneHourAgoTimestamp = strtotime('-1 hour', $timestamp);

    if ($visitorTimestamp >= $oneHourAgoTimestamp && $visitor['hashed_ip'] === $hashedIP) {
        $isNewVisitor = false;
        break;
    }
}

if ($isNewVisitor) {
    $data[$timeZone][] = array(
        'hashed_ip' => $hashedIP,
        'timestamp' => $currentTime
    );


    file_put_contents('ip.json', json_encode($data));
}

function getCountries()
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    $hostname = "mysql";
    $username = "user";
    $password = "user";
    $dbname = "dovolenka";

    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $countries = array();

        $query = "SELECT * FROM countries";

        $statement = $db->prepare($query);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $countries[] = array(
                'name' => $row['name'],
                'country' => $row['state'],
                'number' => $row['number'],
            );
        }
        $json_data = json_encode($countries);

        return $json_data;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function postCountry($data)
{
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    $hostname = "mysql";
    $username = "user";
    $password = "user";
    $dbname = "dovolenka";

    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $selectQuery = "SELECT number FROM countries WHERE name = :name AND state = :state";
        $selectStatement = $db->prepare($selectQuery);
        $selectStatement->bindParam(':name', $data['name']);
        $selectStatement->bindParam(':state', $data['state']);
        $selectStatement->execute();
        $existingCountry = $selectStatement->fetch(PDO::FETCH_ASSOC);

        if (strlen($data["name"]) > 50) {
            http_response_code(500);
            echo json_encode(['message' => 'Data is too long']);
        } else {
            if ($existingCountry) {
                $number = $existingCountry['number'] + 1;
                $updateQuery = "UPDATE countries SET number = :number WHERE name = :name";
                $updateStatement = $db->prepare($updateQuery);
                $updateStatement->bindParam(':number', $number);
                $updateStatement->bindParam(':name', $data['name']);
                $updateStatement->execute();
            } else {
                $number = 1;

                $insertQuery = "INSERT INTO countries (name, state, number) 
                            VALUES (:name, :state, :number)";
                $insertStatement = $db->prepare($insertQuery);
                $insertStatement->bindParam(':name', $data['name']);
                $insertStatement->bindParam(':state', $data['state']);
                $insertStatement->bindParam(':number', $number);
                $insertStatement->execute();
            }

            echo json_encode(['message' => 'Data inserted successfully']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
if (str_contains($_SERVER['REQUEST_URI'], '?')) {
    $request = preg_split('/(\?|=)/', $_SERVER['REQUEST_URI']);
} else {
    $request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
}
$endpoint = $request[1];
$response = [];
header('Content-Type: application/json');
switch ($method) {
    case 'GET':
        if ($endpoint == 'countries') {
            $response = ['message' => 'Read countries'];
            $data = getCountries();
            http_response_code(200);
            echo $data;
            
        }
        else {
            $response = ['error' => 'Endpoint not found'];
            http_response_code(404);
        }

        break;
    case 'POST':
        if ($endpoint == 'countries') {
            $response = ['message' => 'Post country'];
            $data = json_decode(file_get_contents('php://input'), true);
            http_response_code(201);
            postCountry($data);
        } else {
            $response = ['error' => 'Endpoint not found'];
            http_response_code(404);
        }
}

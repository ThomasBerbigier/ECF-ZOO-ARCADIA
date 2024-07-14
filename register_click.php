<?php

require 'vendor/autoload.php';

use MongoDB\Client;

// Réponse en JSON
header('Content-Type: application/json');

// Lit le corps brut de la requête et le décode en tableau associatif PHP
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['animal_id']) || !is_numeric($data['animal_id']) || !isset($data['animal_name'])) {
    
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$animal_id = (int) $data['animal_id'];
$animal_name = $data['animal_name'];

if(getenv('ORMONGO_URL') !== false) {
    $connect = "mongodb://administrateur_arcadia:Mr7aF?nsozX4@iad2-c18-0.mongo.objectrocket.com:52011,iad2-c18-1.mongo.objectrocket.com:52011,iad2-c18-2.mongo.objectrocket.com:52011/zoo_arcadia?replicaSet=3ca8fb33ce9646b19289adf77e800551";
} else {
    // Local
    $connect = "mongodb://localhost:27017";
}

try {
    $client = new Client($connect);
    $collection = $client->zoo_arcadia->animals_clicks;
    
    // Vérification si l'animal doit être enregistré
    $filter = ['animal_id' => $animal_id];
    $existingClick = $collection->findOne($filter);
    
    if (!$existingClick) {
        
        // Animal non enregistré, enregistrement dans MongoDB
        $result = $collection->insertOne([
            'animal_id' => $animal_id,
            'animal_name' => $animal_name,
            'click_count' => 1,
        ]);
        
        if ($result->getInsertedCount() === 1) {
            echo json_encode(['status' => 'success', 'message' => 'Clic enregistré avec succès']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de l\'enregistrement du clic']);
        }
    } else {
        // Animal déjà enregistré, mise à jour du compteur de clics
        $result = $collection->updateOne(
            $filter,
            ['$inc' => ['click_count' => 1]]
        );
        
        if ($result->getModifiedCount() === 1) {
            echo json_encode(['status' => 'success', 'message' => 'Clic enregistré avec succès']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la mise à jour du clic']);
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>

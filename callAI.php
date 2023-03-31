<?php
/*
OpenAI chat with a short-term memory
uses the gpt-3.5-turbo language model
By Harshit Sharma https://twitter.com/harshitethic
https://harshitethic.in
2023
Call this file like this:
callAI.php?text=[the text you'd like a response from]
And it will echo a response from the AI.
You can optionally add ?forget=true to make the AI forget your previous responses before answering
*/

session_start();
$testmode = isset($_GET['testmode']) ? $_GET['testmode'] : null;
$forget = isset($_GET['forget']) ? $_GET['forget'] : null;
if ($forget) {
    $_SESSION['conversations'] = null;
    echo "forgotten";
}

$openai_api_key = '[YOUR_API_KEY_GOES_HERE]';
$number_of_interactions_to_remember = 5;

$text = isset($_GET['text']) ? $_GET['text'] : null;

if ($text) {
    $keywords = array('time', 'date', 'day is it');
    $containsKeyword = false;
    $regex = '/\b(' . implode('|', $keywords) . ')\b/i';
    $containsKeyword = preg_match($regex, $text);

    if ($containsKeyword) {
        $datetime = getDateTime();
        $text = "It is " . $datetime . ". If appropriate, respond to the following in a short sentence: " . $text;
    }

    if (!isset($_SESSION['conversations'])) {
        $_SESSION['conversations'] = array();
    }

    if (count($_SESSION['conversations']) > $number_of_interactions_to_remember + 1) {
        $_SESSION['conversations'] = array_slice($_SESSION['conversations'], -$number_of_interactions_to_remember, $number_of_interactions_to_remember, true);
    }

    $data = array(
        'model' => 'gpt-3.5-turbo',
        'messages' => array(
            array(
                'role' => 'system',
                'content' => 'You are called Chatty McChatface. You give short, friendly responses. '
            )
        )
    );

    foreach ($_SESSION['conversations'] as $conversation) {
        foreach ($conversation as $message) {
            array_push($data['messages'], array(
                'role' => $message['role'],
                'content' => $message['content']
            ));
        }
    }

    array_push($data['messages'], array(
        'role' => 'user',
        'content' => $text
    ));

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $openai_api_key,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

if ($testmode) {
    echo json_encode($data);
    echo "<br><br>";
    echo $response;
    echo "<br><br>";
}
$response = json_decode($response, true);

curl_close($curl);

if (isset($response['choices'][0]['message']['content'])) {
    $content = $response['choices'][0]['message']['content'];
} else {
    $content = "Something went wrong! ```" . json_encode($response) . "```";
}

$new_conversation = array(
    array(
        'role' => 'user',
        'content' => $text
    ),
    array(
        'role' => 'assistant',
        'content' => $content
    )
);

array_push($_SESSION['conversations'], $new_conversation);

echo $content;
}
?>

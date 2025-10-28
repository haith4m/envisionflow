<?php
// ai_request.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$inputJson = file_get_contents('php://input');
$input = json_decode($inputJson, true);

if (json_last_error() !== JSON_ERROR_NONE || !isset($input['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON input']);
    exit;
}

$user_message = trim($input['message'] ?? '');
$history = $input['history'] ?? [];

// WARNING: Your API key was exposed. I have redacted it. 
// Please use an environment variable (getenv) and delete your old key.
$openai_api_key = getenv('OPENAI_API_KEY') ?: 'OPENAI_API_KEY';

$is_finalizing = (stripos($user_message, 'finalize') !== false || stripos($user_message, 'finalise') !== false || stripos($user_message, 'yep') !== false);

$messages = [
    [
        'role' => 'system',
        'content' => "You are EnvisionFlow, a friendly AI business brainstorming assistant. Your mission is to help a user turn a rough idea into a polished, structured business plan in plain, beginner-friendly language.

GUIDELINES:
1. Friendly Language: Use simple words; avoid business jargon.
2. Core Fields (User Input):
   - Project Name (🚀): What’s your project called?
   - What’s Your Idea? (📝): Capture and reword their idea.
   - Who Is It For? (👥): Target audience; suggest examples if unsure.
   - How Will It Work / Make Money? (💼): Simple business model.
   - Where Will You Start? (🏙️): City / town; use for localized predictions.

3. Extra / Predicted Fields (Auto-Fill):
   - What’s the Scene Like? (📈): Local market, competitors, trends.
   - What Will You Offer? (🛠️): Key products or services.
   - Big Steps / Goals (🎯): High-level milestones.
   - First Things to Do (➡️): Immediate next actions.
   - Money Stuff / Rough Estimate (💰): Simple revenue/cost ideas.
   - How Will People Hear About It? (📢): Beginner-friendly marketing ideas.
   - What Will You Need? (📋): Staff, equipment, resources.
   - What Could Go Wrong? (⚠️): Likely risks or challenges.

4. Chat Flow:
   - Ask one core question at a time.
   - Reword user input to be clear and polished.
   - If user skips, respond with 'To be determined – initial brainstorming stage'.
   - Auto-generate extra fields based on idea + city + audience; allow edits.

5. JSON Output:
   - Only generate JSON when user types 'blueprint now' or 'end session'.
   - Output raw JSON with all fields; skipped or unknown fields must have 'To be determined – initial brainstorming stage'.

Your goal: act as a friendly brainstorming partner, help organize ideas, and provide helpful estimates for unknown fields."
    ]
];

foreach ($history as $h) {
    if (isset($h['user'], $h['ai'])) {
        $messages[] = ['role' => 'user', 'content' => $h['user']];
        $messages[] = ['role' => 'assistant', 'content' => $h['ai']];
    }
}

$messages[] = ['role' => 'user', 'content' => $user_message];

// If the user wants to finalize, add a special instruction to the API
if ($is_finalizing) {
    $messages[] = [
        'role' => 'user',
        'content' => "Based on our conversation, please generate the JSON blueprint now. Do not include any conversational text."
    ];
}

$postData = [
    'model' => 'gpt-4o-mini',
    'messages' => $messages,
    'temperature' => 0.7,
    'max_tokens' => 800,
];

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: ' . 'Bearer ' . $openai_api_key,
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

$result = json_decode($response, true);

if (isset($result['error'])) {
    echo json_encode(['error' => $result['error']['message'] ?? 'OpenAI API error']);
    exit;
}

$ai_text = $result['choices'][0]['message']['content'] ?? '';

// Check if the AI's response contains a JSON block
function extract_json_from_text($text) {
    $jsonStart = strpos($text, '{');
    $jsonEnd = strrpos($text, '}');
    if ($jsonStart !== false && $jsonEnd !== false) {
        $jsonString = substr($text, $jsonStart, $jsonEnd - $jsonStart + 1);
        $decoded = json_decode($jsonString, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
    }
    return null;
}

$blueprint_data = extract_json_from_text($ai_text);

$final_response = [];
if ($blueprint_data) {
    $final_response['done'] = true;
    $final_response['blueprint'] = $blueprint_data;
} else {
    $final_response['done'] = false;
    $final_response['reply'] = $ai_text;
}

echo json_encode($final_response);
?>
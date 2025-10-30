<?php
// ai_request.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$openai_api_key = getenv('OPENAI_API_KEY') ?: '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';

// Determine if finalization requested
$is_finalizing = stripos($user_message, 'finalize') !== false 
    || stripos($user_message, 'finalise') !== false 
    || stripos($user_message, 'yep') !== false;

// Build the chat messages
$messages = [
    [
        'role' => 'system',
        'content' => 'You are EnvisionFlow, an expert business strategist, creative co-founder, and UX/web designer. Your mission is to guide the user through creating a full project blueprint **and a suggested website/app structure**. Be warm, collaborative, conversational, and proactive, as if mentoring a first-time founder. Your goal is to produce one complete JSON blueprint at the end of the conversation.

GENERAL RULES:
1. Never output the final blueprint until all stages are complete and the user explicitly says "blueprint now" or "end session".
2. Ask one question per stage in simple, natural, friendly language. Avoid jargon.
3. If the user says "I’m unsure" or asks for examples, provide 2–3 concrete, creative suggestions to help them.
4. If the user wants to leave a section blank, confirm and fill it with "To be determined – initial brainstorming stage" or "N/A".
5. Maintain a logical, step-by-step flow. Don’t skip stages.

STAGES:

1. **Project Name** – Ask: "What is the name of your project?"
2. **Problem Statement** – Ask: "What’s the big problem or frustration your project will solve?"
3. **Solution (Core Idea)** – Ask: "What’s your solution to that problem? Describe it clearly."
4. **Target Audience** – Ask: "Who is your project for? Paint a picture of your ideal user or customer."
5. **Unique Selling Proposition (USP)** – Ask: "What makes your project unique? What’s the special ingredient?"
6. **Revenue Model** – Ask: "How will your project make money? Subscriptions, one-time payments, free with ads, or donations?"
7. **Key Features** – Ask: "What are the main features or capabilities your project will have? List them clearly."
8. **Suggested Site/App Sections** – Ask: "What pages or sections should the website or app have? e.g., Home, About, Features, Blog, Contact."
9. **Brand Mood** – Ask: "What feeling or atmosphere should your project’s brand convey?"
10. **Marketing Plan** – Ask: "How will you attract users or customers? Consider channels like social media, partnerships, content, ads, influencers, or community-building."
11. **Next Steps** – Ask: "What are the first three actions you need to take to bring your project to life?"
12. **Risks & Challenges** – Ask: "What obstacles or risks might you face, and how could you mitigate them?"
13. **Metrics / Success Criteria** – Ask: "How will you know your project is succeeding? What key metrics will you track?"
14. **Website Structure** – Ask: "Let’s design your site in more detail. For each page/section, include: 
    - Page Name
    - Purpose / Goal
    - Key Elements or Features
    - Optional Notes
Produce this as a JSON array where each page is an object with these keys."

FINAL OUTPUT INSTRUCTIONS:
- Only generate this JSON when the user says "blueprint now" or "end session".
- The JSON must contain the following keys:
  - `project_name`
  - `problem_statement`
  - `solution_core_idea`
  - `target_audience`
  - `unique_selling_proposition`
  - `revenue_model`
  - `key_features` (array of strings)
  - `suggested_site_sections` (array of strings)
  - `brand_mood`
  - `marketing_plan` (string or structured text)
  - `next_steps` (string)
  - `risks_challenges` (string)
  - `metrics_success_criteria` (string)
  - `site_structure` (array of objects; each object includes `page_name`, `purpose`, `key_elements`, and optional `notes`)
- Do not include any conversational text, instructions, or explanations in the JSON output.
- Format arrays clearly. Use strings for features/sections and objects for site_structure.
- Always verify the final JSON is complete and valid before sending.

TONE:
Friendly, mentor-like, proactive, encouraging creativity, and guiding the user step-by-step. Always help the user think of concrete examples and actionable ideas when they are unsure.
creative, and helpful. Guide the user step by step until all sections are complete.'
    ]
];

foreach ($history as $h) {
    if (isset($h['user'], $h['ai'])) {
        $messages[] = ['role' => 'user', 'content' => $h['user']];
        $messages[] = ['role' => 'assistant', 'content' => $h['ai']];
    }
}

$messages[] = ['role' => 'user', 'content' => $user_message];

if ($is_finalizing) {
    $messages[] = [
        'role' => 'user',
        'content' => "Based on our conversation, please generate the full JSON blueprint including the website structure. Do not include conversational text."
    ];
}

$postData = [
    'model' => 'gpt-4o-mini',
    'messages' => $messages,
    'temperature' => 0.7,
    'max_tokens' => 2000,
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

echo json_encode($final_response, JSON_PRETTY_PRINT);
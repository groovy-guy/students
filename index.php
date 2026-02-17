<?php

$apiUrl = "https://api.amityonline.com/api/group/664b22f39ec522b1fa1178ae/closed-tab/691eda01af393d4c5b6d3417/members/paginated?page=0&limit=343&query=";

$token = "YOUR_BEARER_TOKEN_HERE"; // <-- Keep token here (secure on server)

// Initialize cURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);

if(curl_errno($ch)){
    echo "Error: " . curl_error($ch);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);
$members = $data['members'] ?? [];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        body { font-family: Arial; padding:20px; background:#f4f6f9; }
        table { width:100%; border-collapse:collapse; background:#fff; }
        th, td { padding:8px; border:1px solid #ddd; font-size:14px; }
        th { background:#2c3e50; color:#fff; }
        img { width:50px; height:50px; border-radius:50%; object-fit:cover; }
        button {
            padding:5px 10px;
            background:#007bff;
            color:#fff;
            border:none;
            border-radius:4px;
            cursor:pointer;
        }
        button:hover { background:#0056b3; }
    </style>
</head>
<body>

<h2>Student List</h2>

<table>
    <thead>
        <tr>
            <th>Profile</th>
            <th>ID</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($members as $member): ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($member['picture']) ?>" alt="Profile">
                </td>
                <td><?= htmlspecialchars($member['id']) ?></td>
                <td><?= htmlspecialchars($member['userId']) ?></td>
                <td><?= htmlspecialchars($member['name']) ?></td>
                <td><?= $member['email'] ? htmlspecialchars($member['email']) : '-' ?></td>
                <td><?= $member['mobile'] ? htmlspecialchars($member['mobile']) : '-' ?></td>
                <td><?= htmlspecialchars($member['tabStatus']) ?></td>
                <td>
                    <a href="https://besocial.amityonline.com/user/<?= htmlspecialchars($member['id']) ?>?profile-tab=profile" target="_blank">
                        <button>View Profile</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

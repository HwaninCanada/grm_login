<?php

include_once include_once 'db.php';

//Getting data from DB
$currentPageNumber = 1;
$perPage = 10;

if($currentPageNumber == 1){
  $offset = 0;
}
else if($currentPageNumber < 1){
  $offset = ($pageNumber - 1) * $perPage;
}


$sql = "SELECT title, posted_at, posted_by FROM posts ORDER BY posted_at DESC LIMIT $perPage OFFSET $offset";

$result = $conn->query($sql);

// Check if there are posts
if ($result->num_rows > 0) {
    // Fetch posts into an associative array
    $posts = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $posts = [];
}

// Close the database connection
$conn->close();

$posts = [
    ['title' => 'Sample Post Title 1', 'content' => 'This is the content for post 1.', 'posted_at' => '2023-12-07 12:34:56', 'posted_by' => 'John Doe', 'image' => 'image1.jpg'],
    ['title' => 'Sample Post Title 2', 'content' => 'This is the content for post 2.', 'posted_at' => '2023-12-08 10:45:30', 'posted_by' => 'Jane Doe', 'image' => 'image2.jpg'],
    // Add more posts as needed
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Community Forum</title>
</head>

<body class="bg-gray-100">

  <!-- Navigation -->
  <div class="bg-blue-500 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
      <div class="text-2xl font-bold">Community Forum</div>
      <!-- Add your user authentication logic here for displaying user-specific elements -->
      <div>
        <!-- Example: Display username and a logout button if the user is logged in -->
        <!-- Replace 'username' and 'logout.php' with your actual authentication logic -->
        <?php if ($loggedInUser): ?>
        <span class="mr-2">Hello, <?php echo $loggedInUser; ?>!</span>
        <a href="logout.php" class="underline">Logout</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto mt-8">

    <!-- Search Bar -->
    <div class="mb-4 flex items-center">
      <input type="text" placeholder="Search..." class="border border-gray-300 p-2 rounded-md flex-grow">
      <button class="bg-blue-500 text-white p-2 rounded-md ml-2">Search</button>
    </div>

    <!-- Display Posts -->
    <?php foreach ($posts as $post): ?>
    <!-- Post Information Row -->
    <div class="flex items-center mb-2">
      <div class="font-bold mr-2"><?php echo $post['title']; ?></div>
      <div class="text-gray-500 mr-2"><?php echo $post['posted_at']; ?></div>
      <div class="text-gray-500"><?php echo $post['posted_by']; ?></div>
    </div>

    <!-- Content Row -->
    <div class="mb-4"><?php echo $post['content']; ?></div>

    <!-- Image Row -->
    <div class="flex items-center mb-2">
      <img src="<?php echo $post['image']; ?>" alt="Post Image" class="w-16 h-16 object-cover rounded-full mr-2">
    </div>

    <!-- Actions Row -->
    <div class="flex">
      <!-- Add your authentication logic here for showing/hiding edit/delete buttons -->
      <!-- Replace 'john_doe' with the actual username of the logged-in user -->
      <?php if ($loggedInUser == $post['posted_by']): ?>
      <button class="bg-green-500 text-white p-2 rounded-md mr-2">Edit</button>
      <button class="bg-red-500 text-white p-2 rounded-md">Delete</button>
      <?php endif; ?>
    </div>

    <!-- Divider Line -->
    <hr class="my-4 border-gray-300">
    <?php endforeach; ?>

    <!-- Button to Write a Post -->
    <div class="mt-8">
      <button class="bg-blue-500 text-white p-2 rounded-md">Write a Post</button>
    </div>

  </div>

</body>

</html>
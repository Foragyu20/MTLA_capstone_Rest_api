<?php
// Assuming you have a database connection
include '../conz.php';

$query = "SELECT 
              ed.id AS english_id, ed.word AS english_word, ed.definition AS english_definition, ed.part_of_speech AS english_part_of_speech, COALESCE(ed.example, '*') AS english_example, 
              pd.id AS pangasinan_id, pd.word AS pangasinan_word, pd.definition AS pangasinan_definition, COALESCE(pd.example, '*') AS pangasinan_example, 
              id.id AS ilocano_id, id.word AS ilocano_word, id.definition AS ilocano_definition, COALESCE(id.example, '*') AS ilocano_example, 
              td.id AS tagalog_id, td.word AS tagalog_word, td.definition AS tagalog_definition, COALESCE(td.example, '*') AS tagalog_example, 
              tr.id AS translation_id, tr.english, tr.pangasinan, tr.ilocano, tr.tagalog
          FROM english_dictionary ed
          LEFT JOIN pangasinan_dictionary pd ON ed.word = pd.word
          LEFT JOIN ilocano_dictionary id ON ed.word = id.word
          LEFT JOIN tagalog_dictionary td ON ed.word = td.word
          JOIN translation tr ON ed.word = tr.english";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output JSON for words and their translations
    $output = [];
    while ($row = $result->fetch_assoc()) {
        $output[] = [
            'english_id' => $row['english_id'],
            'english_word' => $row['english_word'],
            'english_definition' => $row['english_definition'],
            'english_part_of_speech' => $row['english_part_of_speech'],
            'english_example' => $row['english_example'],
            'pangasinan_id' => $row['pangasinan_id'],
            'pangasinan_word' => $row['pangasinan_word'],
            'pangasinan_definition' => $row['pangasinan_definition'],
            'pangasinan_example' => $row['pangasinan_example'],
            'ilocano_id' => $row['ilocano_id'],
            'ilocano_word' => $row['ilocano_word'],
            'ilocano_definition' => $row['ilocano_definition'],
            'ilocano_example' => $row['ilocano_example'],
            'tagalog_id' => $row['tagalog_id'],
            'tagalog_word' => $row['tagalog_word'],
            'tagalog_definition' => $row['tagalog_definition'],
            'tagalog_example' => $row['tagalog_example'],
            'translation_id' => $row['translation_id'],
            'english' => $row['english'],
            'pangasinan' => $row['pangasinan'],
            'ilocano' => $row['ilocano'],
            'tagalog' => $row['tagalog']
        ];
    }

    echo json_encode($output);
} else {
    echo json_encode(['message' => 'No matching words found']);
}

// Close the database connection
$conn->close();
?>

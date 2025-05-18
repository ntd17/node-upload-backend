<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>File Upload Frontend</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">
  <h1 class="text-4xl font-bold mb-8 text-gray-900">Upload File to Node.js Backend</h1>
  <form id="uploadForm" class="bg-white p-6 rounded shadow-md w-full max-w-md" enctype="multipart/form-data">
    <label for="fileInput" class="block mb-4 text-gray-700 font-semibold">Select a file to upload:</label>
    <input type="file" id="fileInput" name="file" required class="mb-6 w-full border border-gray-300 rounded px-3 py-2" />
    <button type="submit" class="w-full bg-black text-white py-3 rounded hover:bg-gray-800 transition">Upload</button>
  </form>
  <div id="result" class="mt-6 max-w-md w-full text-gray-800"></div>

  <script>
    const form = document.getElementById('uploadForm');
    const resultDiv = document.getElementById('result');
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fileInput = document.getElementById('fileInput');
      if (!fileInput.files.length) {
        alert('Please select a file.');
        return;
      }
      const file = fileInput.files[0];
      const reader = new FileReader();
      reader.onload = async function(event) {
        const base64Content = event.target.result.split(',')[1];
        const payload = {
          filename: file.name,
          content_base64: base64Content
        };
        try {
          const response = await fetch('https://f8zvys-8080.csb.app/upload', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
          });
          if (!response.ok) {
            throw new Error('Upload failed: ' + response.statusText);
          }
          const data = await response.json();
          resultDiv.textContent = 'Upload successful! Response: ' + JSON.stringify(data);
        } catch (error) {
          resultDiv.textContent = 'Error: ' + error.message;
        }
      };
      reader.readAsDataURL(file);
    });
  </script>
</body>
</html>

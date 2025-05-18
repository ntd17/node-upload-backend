
Built by https://www.blackbox.ai

---

# Node Upload Backend

## Project Overview
Node Upload Backend is a Node.js application that handles file uploads and converts them to a CAR (Content Addressable Representation) format. This server utilizes a simple REST API to receive files encoded in base64 and respond with the processed data, suitable for integration with various storage solutions.

## Installation

To set up the project locally, follow these steps:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/ntd17/node-upload-backend.git
   cd node-upload-backend
   ```

2. **Install dependencies**:
   Make sure you have [Node.js](https://nodejs.org/) (version 14 or higher) installed. Then run:
   ```bash
   npm install
   ```

3. **Create an environment file**:
   Create a `.env` file in the root directory and add the required environment variables:
   ```
   PORT=8080
   TEMP_DIR=/tmp
   AUTHORIZATION=your_authorization_token
   X_AUTH_SECRET=your_auth_secret
   DID=your_did_value
   ```

4. **Run the application**:
   You can start the application with:
   ```bash
   npm start
   ```
   The server will be available at `http://localhost:8080`.

## Usage

To upload a file to the server, send a POST request to the `/upload` endpoint with a JSON body containing the following fields:
- `filename`: The name of the file to be uploaded.
- `content_base64`: The base64 encoded content of the file.

**Example POST Request**:
```bash
curl -X POST http://localhost:8080/upload \
     -H 'Content-Type: application/json' \
     -d '{"filename": "example.txt", "content_base64": "SGVsbG8gV29ybGQ="}'
```

## Features

- File upload handling via a RESTful API.
- Automatic conversion of uploaded files to CAR format.
- Base64 encoding/decoding for file contents.
- Clean-up of temporary files after processing.
- Designed to be compatible with various storage APIs.

## Dependencies

The project requires the following dependencies, as defined in `package.json`:

- `axios`: ^1.4.0 - Promise based HTTP client for the browser and Node.js
- `dotenv`: ^16.0.0 - Module to load environment variables from a `.env` file
- `express`: ^4.18.2 - Fast, unopinionated, minimalist web framework for Node.js
- `uuid`: ^9.0.0 - Utility for generating random UUIDs

## Project Structure

```
node-upload-backend/
├── .env                  # Environment variables
├── docker-compose.yml    # Docker Compose file for containerization
├── package.json          # Node.js project manifest
└── server.js             # Main server file
```

### Docker Support

To run the application using Docker, ensure Docker is installed on your machine. You can use the provided `docker-compose.yml` file to build and run the services.

Run the following command in the project root directory:
```bash
docker-compose up --build
```

The Node.js application will be accessible on port `8080` and any connected frontend service can access it as specified in the `docker-compose.yml`.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments
- Thanks to the contributors and the open-source community for their libraries and tools that make building and deploying software easier.

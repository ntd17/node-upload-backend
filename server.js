import express from 'express';
import fs from 'fs/promises';
import path from 'path';
import { execSync } from 'child_process';
import axios from 'axios';
import { fileURLToPath } from 'url';
import { dirname } from 'path';
import { v4 as uuidv4 } from 'uuid';
import dotenv from 'dotenv';

dotenv.config();

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const app = express();
const PORT = process.env.PORT || 8080;
const TEMP_DIR = process.env.TEMP_DIR || '/tmp';

const AUTHORIZATION = process.env.AUTHORIZATION;
const X_AUTH_SECRET = process.env.X_AUTH_SECRET;
const DID = process.env.DID;

app.use(express.json({ limit: '50mb' }));

app.post('/upload', async (req, res) => {
  try {
    const { filename, content_base64 } = req.body;
    if (!filename || !content_base64) {
      return res.status(400).json({ error: 'Os campos "filename" e "content_base64" são obrigatórios.' });
    }

    const uniqueFilename = `${uuidv4()}_${filename}`;
    const tempFilePath = path.join(TEMP_DIR, uniqueFilename);
    const carPath = tempFilePath + '.car';

    await fs.writeFile(tempFilePath, Buffer.from(content_base64, 'base64'));

    execSync(`w3 car pack ${tempFilePath} --output ${carPath}`);

    const carBytes = await fs.readFile(carPath);
    const carBase64 = Buffer.from(carBytes).toString('base64');

    const payload = {
      tasks: [["upload/add", DID, { input: { car: { "/": carBase64 } } }]]
    };

    const response = await axios.post('https://up.storacha.network/bridge', payload, {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': AUTHORIZATION,
        'X-Auth-Secret': X_AUTH_SECRET
      }
    });

    await fs.unlink(tempFilePath).catch(() => {});
    await fs.unlink(carPath).catch(() => {});

    res.json(response.data);
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: err.message });
  }
});

app.listen(PORT, () => {
  console.log(`🚀 Servidor rodando na porta ${PORT}`);
});

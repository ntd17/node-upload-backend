# Dockerfile (Node.js Backend)
FROM node:16-alpine

WORKDIR /app

# Copy and install dependencies
COPY package.json ./
RUN npm install

# Copy source code
COPY . .

# Expose the application port
EXPOSE 8080

# Start the application
CMD ["npm", "start"]

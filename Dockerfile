# Stage 1: Build the Vue.js SPA
FROM node:20-alpine as build-stage

WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application
COPY . .

# Build the application for production
RUN npm run build

# Stage 2: Serve the built application with Nginx
FROM nginx:alpine as production-stage

# Copy the build output to Nginx's default public directory
COPY --from=build-stage /app/dist /usr/share/nginx/html

# Copy custom Nginx configuration for routing and security
COPY nginx.conf /etc/nginx/nginx.conf

# Expose port 80 (or 8000 to match previous setup, let's stick to 80 for standard Nginx but map it in compose)
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

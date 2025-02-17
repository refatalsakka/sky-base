# ✈️ SkyBase

SkyBase is a robust and scalable backend platform designed to streamline aviation operations by efficiently managing personnel data, assignments, and organizational structures. It provides an intuitive API for seamless integration with other systems while maintaining top-tier security and compliance with industry standards.

---

## 💪 Installation & Setup

Follow these steps to set up SkyBase on your local or production environment.

### 🛠️ Prerequisites
Ensure you have the following installed:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- Make (for running commands efficiently)

---

## 🚀 Running the Application

### 1️⃣ Build & Start the Application
- **Development Environment:**
  ```sh
  make build-dev
  ```
  This will build and start the development environment.

- **Production Environment:**
  ```sh
  make build-prod
  ```
  This will build and start the production environment.

### 2️⃣ Stop Running Containers (Both Dev & Prod)
To stop the running containers (works for both environments):
```sh
make stop
```

### 3️⃣ Start Stopped Containers (Both Dev & Prod)
To start previously stopped containers without rebuilding:
```sh
make start
```

### 4️⃣ Access Apache Container (For Debugging - Dev & Prod)
To open a bash shell inside the Apache container:
```sh
make bash
```

### 5️⃣ View Logs (For Debugging - Dev & Prod)
To view real-time logs of the Apache container:
```sh
make logs
```

### 6️⃣ Clear and Warmup Cache (Recommended for Both Dev & Prod)
To clear and warm up Symfony cache:
```sh
make clear-cache
```

---

## 🛠 Database Management

### 1️⃣ Reset Development Database (**For Development Only**)
If you need to reset the development database:
```sh
make reset-dev
```
This will:
- Remove all migration files
  ```sh
  make rm-migrations
  ```
- Drop and recreate the database
  ```sh
  make drop-db || true
  make create-db
  ```
- Generate a new migration file
  ```sh
  make diff
  ```
- Run migrations
  ```sh
  docker compose exec apache php bin/console doctrine:migrations:migrate --no-interaction
  ```
- Load development fixtures
  ```sh
  docker compose exec apache php bin/console doctrine:fixtures:load --group=dev --no-interaction
  ```

### 2️⃣ Individual Database Commands (For Dev & Prod)
- **Create database:** (Use in both dev & prod when setting up the database for the first time)
  ```sh
  make create-db
  ```
- **Drop database:** (Typically used in development to reset data)
  ```sh
  make drop-db
  ```
- **Remove all migration files:** (Useful for resetting migrations in development)
  ```sh
  make rm-migrations
  ```
- **Generate new migration files:** (Use in development to track schema changes)
  ```sh
  make diff
  ```
- **Run migrations:** (Required for both dev & prod to apply schema changes)
  ```sh
  make migrate
  ```
- **Load production fixtures:** (Used for inserting required production data)
  ```sh
  make load-fixtures-prod
  ```
- **Load development fixtures:** (Used for inserting test data in development)
  ```sh
  make load-fixtures-dev
  ```

---

## 📖 API Documentation

SkyBase provides an OpenAPI-compliant API documentation that allows you to explore available endpoints, test requests, and view response structures.

Access the API documentation here:
➡️ [SkyBase API Docs](http://localhost:8200/api/docs)

## 📌 TODO List

[View TODO.md](TODO.md)

---

## 📝 License
SkyBase is licensed under the [MIT License](LICENSE).

---

### 🎯 Notes
- Ensure your `.env` file is properly configured before running the project.
- Make sure the database is up and running inside the container before running migrations.
- If you encounter permission issues, try running `sudo chmod -R 777 var/` inside the Apache container.
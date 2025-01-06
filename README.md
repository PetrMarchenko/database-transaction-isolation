# Database Isolation Levels Simulation

This project is designed to help you understand and visualize the behavior of databases under different isolation levels. It provides practical examples of common database phenomena such as dirty reads, non-repeatable reads, phantom reads, and write skew. By simulating various isolation levels, you can observe how different levels affect data consistency and concurrency.

### Database Isolation Levels

In relational databases, isolation levels define the degree to which one transaction must be isolated from other concurrent transactions. The following isolation levels are commonly used:

1. **READ UNCOMMITTED**: The lowest level of isolation where transactions can read data that has not yet been committed, which may lead to "dirty reads."
2. **READ COMMITTED**: Transactions can only read committed data, preventing dirty reads but still allowing non-repeatable reads.
3. **REPEATABLE READ**: Ensures that if a transaction reads data, it will always see the same value for that data throughout the transaction, preventing non-repeatable reads but not phantom reads.
4. **SERIALIZABLE**: The highest level of isolation where transactions are executed one after another, preventing dirty reads, non-repeatable reads, and phantom reads.

### Examples Covered in This Project

- **Dirty Reads**: This occurs when a transaction reads uncommitted data that may later be rolled back.
- **Non-Repeatable Reads**: This happens when a transaction reads data twice, but another transaction modifies the data in between, causing inconsistent results.
- **Phantom Reads**: Occurs when a transaction reads data that matches a condition, but another transaction inserts new rows that match the condition before the transaction is complete.
- **Write Skew**: A situation where two transactions read the same data, and each makes an update based on that data, leading to conflicting changes.

### Summary of Isolation Levels and Their Impact

| Isolation Level   | Dirty Reads | Non-Repeatable Reads | Phantom Reads | Write Skew |
|-------------------|-------------|----------------------|---------------|------------|
| READ UNCOMMITTED  | Yes         | Yes                  | Yes           | Yes        |
| READ COMMITTED    | No          | Yes                  | Yes           | Yes        |
| REPEATABLE READ   | No          | No                   | Yes           | Yes        |
| SERIALIZABLE      | No          | No                   | No            | No         |

By simulating these scenarios with different isolation levels, this project provides valuable insights into the behavior of databases under various concurrency control mechanisms.

# Project Installation Guide

This project demonstrates the behavior of a database under different isolation levels in various transaction scenarios. Below are the steps to set up the environment and get started.

## Installation Steps

### 1. Clone the Repository
First, clone the repository to your local machine:

```bash
git clone https://github.com/PetrMarchenko/database-transaction-isolation
cd database-transaction-isolation
```

###  2. Copy the .env File for the Application
Once you're in the root directory of the project, copy the .env.example file to .env for the application configuration:

```bash
cp .env.example .env
```

### 3. Navigate to the Docker Directory
   The project has a docker directory containing the Docker-related configuration. Move into this directory:

```bash
cd docker
```
### 4. Copy the .env File for Docker Configuration
Next, copy the .env.example file to .env in the docker directory:

```bash
cp .env.example .env
```

### 5. Build and Start Docker Services
Run the following command to build and start the necessary Docker containers:

```bash
docker compose up -d 
```

### 6. Install Composer Dependencies
   Install the necessary PHP dependencies using Composer:

```bash
docker compose exec php-fpm composer install -n --prefer-dist
```

### 7. Generate the Application Key
Generate the application key:

```bash
docker compose exec php-fpm php artisan key:generate
```

### 8. Run Database Migrations
Run the migrations to set up the database schema:

```bash
docker compose exec php-fpm php artisan migrate
```


## How to Use

To simulate different database scenarios, you need to execute commands inside the Docker container where the application is running.

### Step 1: Enter the Docker Container
First, enter the running Docker container:

```bash
docker exec -it php /bin/bash
```

### Step 2: Running Simulation Commands
Inside the container, you can run various simulation commands to test different isolation levels. 
Each command simulates a different type of issue or behavior in the database. Here are the available commands:

1. Simulate Dirty Reads
The dirty-reads command simulates a scenario where one transaction reads uncommitted changes from another transaction.

```bash
php artisan simulate:dirty-reads
```

2. Simulate Non-Repeatable Reads
The non-repeatable-reads command simulates a situation where a transaction reads the same data twice, 
but another transaction changes the data in between, leading to inconsistent results.

```bash
php artisan simulate:non-repeatable-reads
```

3. Simulate Phantom Reads
The phantom-reads command simulates a scenario where a transaction reads a set of data, 
and another transaction inserts new rows that match the query condition, affecting the result when the transaction re-runs the query.

```bash
php artisan simulate:phantom-reads
```

4. Simulate Write Skew
The write-skew command simulates a scenario where two transactions read the same data 
and make conflicting updates based on those reads, which can lead to inconsistent results.

```bash
php artisan simulate:write-skew
```

### Step 3: Choose the Isolation Level
For each of the above commands, you will be prompted to choose an isolation level. 
Select the appropriate level based on the behavior you want to observe. 

Here's how the isolation levels work:
0. **READ UNCOMMITTED**: Allows dirty reads, non-repeatable reads, phantom reads, and write skew.
1. **READ COMMITTED**: Prevents dirty reads but allows non-repeatable reads, phantom reads, and write skew.
2. **REPEATABLE READ**: Prevents dirty reads and non-repeatable reads but allows phantom reads and write skew.
3. **SERIALIZABLE**: Prevents dirty reads, non-repeatable reads, phantom reads, and write skew.

###  Step 4: Observe the Results
After selecting the isolation level, the simulation will run, 
and you will be able to observe how the behavior of the database changes under different isolation levels. 
This is useful for understanding how isolation affects transaction consistency and concurrency.

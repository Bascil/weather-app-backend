# weather-app-backend

A high performance, scalable backend service built with Laravel 11, optimized for Google Cloud Run, using FrankenPHP and Docker. It includes unit tests and benchmarking tools to ensure robustness and efficiency.

## Table of Contents

-   [Demo](#demo)
-   [Technologies](#technologies)
-   [Approach](#approach)
-   [Installation](#installation)
-   [Usage](#usage)
-   [Benchmarking](#benchmarking)
-   [Unit Tests](#unit-tests)

### Demo

The frontend is decoupled from backend and is hosted on Netlify.

-   **Live Demo**: [Link](https://weather-app-frontend-ui.netlify.app)
-   **Frontend Repo**: [Repo](https://github.com/Bascil/weather-app-frontend)
-   **Technology**: NextJs 14

### Technologies

-   **Laravel 11**: Latest version.
-   **Google Cloud Run**: Serverless deployment for scalable and efficient hosting.
-   **FrankenPHP**: Optimized web server with embedded PHP.
-   **Docker**: Containerization for a consistent development and production environment.
-   **Muiltistage Build**: Optimized build process for cloud deployment.
-   **wrk**: HTTP benchmarking tool.

### Approach

The project is built with a focus on performance, scalability, and maintainability:

-   Performance: Leveraging FrankenPHP and Sultistate build for optimized resource usage.
-   Scalability: Deployed on Google Cloud Run, allowing auto-scaling based on demand.
-   Maintainability: Clean code practices, unit tests, and CI/CD with google cloud build.

### Installation

This project can be run locally if docker is installed or on any serverless container runtime such as google cloud run.

```
docker run -p 8080:9804 -t basilndonga/weather-app-backend
```

If you encounter issues with permissions use **sudo** before the docker command

### Usage

#### API Enpoints

1. Heath ckeck

    ```
    curl -v http://localhost:8080/api/health-check
    ```

2. Get Weather Data

    ```
    curl "http://localhost:8080/api/v1/weather/data?units=metric&city=nairobi"
    ```

3. Get 3-day Weather Forecast:

    ```
    curl "http://localhost:8080/api/v1/weather/forecast?cnt=16&units=metric&city=nairobi"

    ```

### Benchmarking

Run a benchmark on 16 threads, 100 connections over 30s duration. Use wrk for performance testing

```
wrk -t16 -c100 -d30s --latency http://127.0.0.1:8080/api/health-check

Running 30s test @ http://127.0.0.1:8080/api/health-check
  16 threads and 100 connections
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency    37.23ms   13.26ms 129.78ms   74.33%
    Req/Sec   161.91     30.97   310.00     70.35%
  Latency Distribution
     50%   36.94ms
     75%   44.86ms
     90%   52.69ms
     99%   72.46ms
  77558 requests in 30.07s, 12.65MB read
Requests/sec:   2579.56
Transfer/sec:    430.77KB

```

### Unit Tests

Unit tests are written using PHPUnit to ensure code quality and reliability.

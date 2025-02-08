const express = require('express');
const bodyParser = require('body-parser');
const requestIp = require('request-ip')

const redis = require('redis');
const Queue = require('bull');

const redisConfig = { host: '127.0.0.1', port: 6379 };

const app = express();

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// const ipAddress = requestIp.getClientIp(req);
app.use((req, res, next) => {
    console.log(`Incoming Request:`);
    console.log(`Method: ${req.method}`);
    console.log(`URL: ${req.url}`);
    console.log('Headers:', req.headers);
    console.log('Body:', req.body);
    console.log('IPAddress:', requestIp.getClientIp(req))
    console.log('-----------------------------');
    next();
});

const myQueue = new Queue('ipAddresses', { redis: redisConfig });

// Create a Redis client
const redisClient = redis.createClient(redisConfig);

// Handle Redis connection errors
redisClient.on('error', (err) => {
    console.error('Redis error:', err);
});

// Process jobs from the queue
// const job = ''
// job.data.key = 'psec_ban'
// job.data.value = requestIp.getClientIp(req) 

myQueue.process(async (job) => {

    // Insert the key-value pair into Redis
    // redisClient.set(key, value, (err, reply) => {
    redisClient.set('psec_ban', requestIp.getClientIp(req) , (err, reply) => {
        if (err) {
            console.error(`Failed to insert key: ${key}`, err);
            throw err; // Mark the job as failed
        }
        console.log(`Inserted key: ${key}, value: ${value}`);
    });
});

// Handle completed jobs
myQueue.on('completed', (job, result) => {
    console.log(`Job ${job.id} completed!`);
});

// Handle failed jobs
myQueue.on('failed', (job, err) => {
    console.error(`Job ${job.id} failed with error:`, err);
});

console.log('Worker is running and ready to process jobs...');

app.all('*', (req, res) => {
    res.status(200).json({
        message: 'Request received!',
        method: req.method,
        url: req.url,
        headers: req.headers,
        body: req.body
    });
});

// Start the server
const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});

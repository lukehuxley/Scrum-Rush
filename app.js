const express = require('express')
const app = express()

const userRoutes = require('./api/routes/user.js')

app.use('/user', userRoutes)

module.exports = app
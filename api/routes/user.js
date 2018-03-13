const express = require('express')
const router = express.Router()

router.post('/create', (req, res, next) => {
    res.status(200).json({
        message: 'Happy path'
    })
})

module.exports = router
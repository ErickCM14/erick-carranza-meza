const jwt = require('jsonwebtoken');
const mongoose = require('mongoose');
const AccessToken = require('./models/AccessToken');
require('dotenv').config();

const USERID = process.env.USERID;
// const token = jwt.sign({ _id: USERID }, process.env.JWT_SECRET, { expiresIn: '1h' });
const TOKEN = jwt.sign({ _id: USERID }, process.env.JWT_SECRET);

console.log('Generated Token:', TOKEN);

mongoose.connect(process.env.MONGO_URI, { useNewUrlParser: true, useUnifiedTopology: true })
    .then(async () => {
        const existingToken = await AccessToken.findOne({ user_id: USERID });

        if (existingToken) {
            console.log('Token exists:', existingToken);
        } else {
            // Insertar el nuevo token si no existe
            const result = await AccessToken.create({ user_id: USERID, token: TOKEN });
            console.log('Token saved to database:', result);
        }
        mongoose.disconnect();
    })
    .catch(err => console.error('MongoDB connection error:', err));
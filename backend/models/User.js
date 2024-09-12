const mongoose = require('mongoose');

const userSchema = new mongoose.Schema({
    name: String,
    phone: String,
    img_profile: String
}, {
    timestamps: true  // Agrega automáticamente createdAt y updatedAt
});

module.exports = mongoose.model('User', userSchema, 'users');
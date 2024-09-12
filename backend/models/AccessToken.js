const mongoose = require('mongoose');

const accessTokenSchema = new mongoose.Schema({
    user_id: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
    token: String
}, {
    timestamps: true  // Agrega automáticamente createdAt y updatedAt
});

module.exports = mongoose.model('AccessToken', accessTokenSchema, 'access_tokens');

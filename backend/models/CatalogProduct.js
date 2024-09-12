const mongoose = require('mongoose');

const catalogProductSchema = new mongoose.Schema({
    name: {
        type: String,
        required: true,
        trim: true
    },
    description: {
        type: String,
        required: true,
        trim: true
    },
    height: {
        type: Number,
        required: true,
        min: 0
    },
    length: {
        type: Number,
        required: true,
        min: 0
    },
    width: {
        type: Number,
        required: true,
        min: 0
    },
    image: {
        type: String,
        default: 'images/product.jpg',
        trim: true
    }
}, {
    timestamps: true  // Agrega automáticamente createdAt y updatedAt
});

module.exports = mongoose.model('CatalogProduct', catalogProductSchema, 'catalog_products');
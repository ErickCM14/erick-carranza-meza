const express = require('express');
const router = express.Router();
const Joi = require('joi');
const CatalogProduct = require('../models/CatalogProduct');
const jwt = require('jsonwebtoken');
const AccessToken = require('../models/AccessToken');


// Middleware de autenticación
const authenticate = async (req, res, next) => {
    const token = req.header('Authorization')?.replace('Bearer ', '');
    if (!token) return res.status(401).send('Access denied.');

    try {
        const decoded = jwt.verify(token, process.env.JWT_SECRET);

        const accessToken = await AccessToken.findOne({ token });

        if (!accessToken) return res.status(401).json({ error: true, message: 'Invalid token.' });

        req.user = decoded;
        next();
    } catch (ex) {
        res.status(400).json({ error: true, message: 'Invalid token.', data: ex });
    }
};

// Validación con Joi
const productSchema = Joi.object({
    name: Joi.string().required(),
    description: Joi.string().required(),
    height: Joi.number().min(0.1).required(),
    length: Joi.number().min(0.1).required(),
    width: Joi.number().min(0.1).required()
});

// Obtener productos
router.get('', authenticate, async (req, res) => {
    try {
        const products = await CatalogProduct.find();
        res.json({ error: false, message: 'Products retrieved successfully', data: products });
    } catch (error) {
        res.status(500).send(error.message);
    }
});

// Obtener productos por id
router.get('/:id', authenticate, async (req, res) => {
    try {
        const product = await CatalogProduct.findOne({ _id: req.params.id });
        res.json({ error: false, message: 'Product retrieved successfully', data: product });
    } catch (error) {
        res.status(500).send(error.message);
    }
});

// Crear producto
router.post('/', authenticate, async (req, res) => {
    const { error } = productSchema.validate(req.body);
    if (error) return res.status(400).json({ error: true, message: error.details[0].message, data: req.body });

    try {
        const product = new CatalogProduct(req.body);
        await product.save();
        res.status(201).json({ error: false, message: 'Product created', data: product });
    } catch (error) {
        res.status(500).send(error.message);
    }
});

// Actualizar producto
router.put('/:id', authenticate, async (req, res) => {
    const { error } = productSchema.validate(req.body);
    if (error) return res.status(400).json({ error: true, message: error.details[0].message, data: req.body });

    try {
        const product = await CatalogProduct.findByIdAndUpdate(req.params.id, req.body, { new: true });
        if (!product) return res.status(404).json({ error: true, message: 'Product not found', data: [] });
        res.json({ error: false, message: 'Product updated', data: product });
    } catch (error) {
        res.status(500).send(error.message);
    }
});

// Eliminar producto
router.delete('/:id', authenticate, async (req, res) => {
    try {
        const product = await CatalogProduct.findByIdAndDelete(req.params.id);
        if (!product) return res.status(404).json({ error: true, message: 'Product not found', data: [] });
        res.json({ error: false, message: 'Product deleted', data: product });
    } catch (error) {
        res.status(500).send(error.message);
    }
});

module.exports = router;

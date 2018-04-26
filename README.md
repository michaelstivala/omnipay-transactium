# Omnipay: Transactium


**Transactium driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements Transactium support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply run

    $ composer require "michaelstivala/omnipay-transactium": "^0.1",


## Basic Usage

This is not a complete wrapper, but exposes the following Transactium web service methods:

- CreateHostedPayment as `purchase`
- GetHostedPayment as `getHostedPayment`
- RefundByFxlId as `refund`
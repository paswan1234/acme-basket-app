# Acme Basket App

This is a PHP-based proof of concept for Acme Widget Co’s new sales system. The application demonstrates clean object-oriented design, test-driven development, and adherence to modern engineering best practices.

## Problem Statement

Acme Widget Co offers the following products:

| Product Code | Product Name | Price  |
|--------------|--------------|--------|
| R01          | Red Widget   | $32.95 |
| G01          | Green Widget | $24.95 |
| B01          | Blue Widget  | $7.95  |

### Special Offer

- Buy one Red Widget (`R01`), get the second one at half price.

### Delivery Rules

- Orders under $50: delivery cost is $4.95
- Orders under $90: delivery cost is $2.95
- Orders of $90 or more: free delivery

## Features

- Clean and modular implementation using modern PHP (8.1+)
- Interface-driven design with constructor injection
- Fully tested using PHPUnit
- Static analysis via PHPStan (level 6)
- Composer-based autoloading using PSR-4
- Easy to extend and maintain

## Project Structure

/src - Basket logic and interfaces
/tests - PHPUnit test cases
composer.json - Autoloading and dependencies
phpstan.neon - PHPStan configuration


## Getting Started

1. Clone the repository:
    ```
    git clone https://github.com/paswan1234/acme-basket-app.git
    cd acme-basket-app
    ```

2. Install dependencies:
    ```
    composer install
    ```

3. Run tests:
    ```
    vendor/bin/phpunit
    ```

4. Run static analysis:
    ```
    vendor/bin/phpstan analyse
    ```

## Sample Scenarios

| Basket Items                 | Expected Total |
|-----------------------------|----------------|
| B01, G01                    | $37.85         |
| R01, R01                    | $54.37         |
| R01, G01                    | $60.85         |
| B01, B01, R01, R01, R01     | $98.27         |

## Assumptions

- Offers are applied before delivery charges.
- Offers and delivery rules are passed into the `Basket` constructor to allow for configurability.
- Delivery thresholds are evaluated from highest to lowest to determine applicable charge.
- Rounding behavior for half-price Red Widgets uses floor rounding to match provided test cases.

## Potential Improvements
- Implement the Strategy Pattern to abstract offer logic
- Add support for multiple types of promotions or coupons
- Add Docker support for containerized execution
- Extend to a CLI or REST API interface

## Author

Jitendra Paswan  
[https://github.com/paswan1234](https://github.com/paswan1234)

## License

This project is licensed under the MIT License.

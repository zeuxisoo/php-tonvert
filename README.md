# Tonvert

Tiny program to convert a format to common format

## Usage

Convert string from `sample.txt` and output result to console

    php ./bin/tonvert tran --in=/path/to/your/sample.txt

Convert string from `sample.txt` and output result to `output.txt`

    php ./bin/tonvert tran --in=/path/to/your/sample.txt --out=/path/to/your/output.txt

Example case

    php ./bin/tonvert tran --in=/path/to/tests/Tonvert/Test/Fixtures/default.txt

## Development

Get composer

    make composer

Install packages

    php composer.phar install

Update autoload

    make autoload

Run test case

    make test

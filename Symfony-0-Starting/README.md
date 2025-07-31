# Symfony-0-Starting

This module provides an introduction to PHP fundamentals, covering the basic concepts necessary before tackling Symfony. It includes 7 progressive exercises that explore data types, file manipulation, associative arrays, and dynamic HTML content generation.

## Module Structure

```
Symfony-0-Starting/
├── ex00/        # Variable types and functions
├── ex01/        # CSV file reading
├── ex02/        # Array to hash conversion
├── ex03/        # Sorted hashes
├── ex04/        # State capital lookup
├── ex05/        # Bidirectional State/Capital search
└── ex06/        # Periodic table generation
```

## Exercises

### Ex00 - Variables and Types
**File:** `var.php`

Exploration of PHP data types and the `gettype()` function.
- Declaration of variables of different types (int, string, float)
- Display of values and their types
- Use of global variables in a function

**Execution:**
```bash
php var.php
```

### Ex01 - CSV File Reading
**Files:** `csv.php`, `ex01.txt`

Reading and processing a simple CSV file.
- `read()` function to read a file
- File error handling
- CSV parsing with `explode()`
- Data cleaning with `trim()`

**Execution:**
```bash
php csv.php
```

### Ex02 - Array to Hash Conversion
**Files:** `array2hash.php`, `test02.php`

Converting a 2D array to an associative array.
- `array2hash()` function that transforms pairs into hash
- Data structure validation
- Error case handling

**Example:**
```php
$array = array(array("Pierre","30"), array("Mary","28"));
// Result: Array ( [30] => Pierre [28] => Mary )
```

**Execution:**
```bash
php test02.php
```

### Ex03 - Sorted Hashes
**Files:** `array2hash_sorted.php`, `test03.php`

Extension of the previous exercise with result sorting.
- Same logic as ex02 but with sorting
- Empty array handling
- Descending sort with `rsort()`

**Execution:**
```bash
php test03.php
```

### Ex04 - State Capitals
**Files:** `capital_city_from.php`, `test04.php`

Capital lookup from US state name.
- Associative arrays for states and capitals
- `capital_city_from()` function
- Handling of non-existent states
- Data type validation

**Available data:**
- Oregon → Salem
- Alabama → Montgomery  
- New Jersey → Trenton
- Colorado → [no capital defined]

**Execution:**
```bash
php test04.php
```

### Ex05 - Bidirectional Search
**Files:** `search_by_states.php`, `test05.php`

Advanced search allowing to find states or capitals.
- `search_by_states()` function
- Search by state name or capital name
- Support for multiple searches (comma-separated)
- Descriptive error messages
- Use of `array_flip()` and `array_search()`

**Features:**
- Search by state name → returns capital
- Search by capital name → returns state
- Multiple input handling
- Error messages for invalid inputs

**Execution:**
```bash
php test05.php
```

### Ex06 - Periodic Table
**Files:** `mendeleiev.php`, `mendeleiev.html`, `ex06.txt`

Dynamic generation of an HTML periodic table of elements.
- Reading a chemical element data file
- Complex structured data parsing
- Dynamic HTML generation
- Element positioning in a grid
- CSS for table styling

**Data structure:**
```
Element_Name = position:X; number:Y; small:Z; molar:W; electrons:V
```

**Features:**
- Reading 119 chemical elements
- Generation of an 18×10 table
- Display of each element's properties
- Interactive web interface

**Execution:**
```bash
php mendeleiev.php
```
Then open `mendeleiev.html` in a browser.

## Skills Developed

### Basic PHP
- Data types and variables
- Functions and variable scope
- Error handling
- File manipulation

### Data Structures
- Indexed and associative arrays
- Conversion between structures
- Sorting and searching
- Complex data manipulation

### File Processing
- Text file reading
- CSV parsing
- Custom format parsing
- File error handling

### Content Generation
- Dynamic HTML
- Embedded CSS
- Web user interface

## Prerequisites

- PHP 7.0 or higher
- Web server (for ex06) or command line
- Web browser (to view ex06)

## General Execution

Each exercise can be executed individually:

```bash
cd Symfony-0-Starting/ex0X/
php filename.php
```

For exercise 06, after running the PHP script, open the generated HTML file in your browser to see the periodic table.

## Important Notes

- All exercises use "vanilla" PHP without frameworks
- Error handling is basic but functional
- Code follows standard PHP conventions
- Exercise 06 demonstrates PHP/HTML/CSS integration

This module effectively prepares for the more advanced concepts that will be covered in subsequent Symfony modules, establishing a solid foundation in PHP and data manipulation.

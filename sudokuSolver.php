<?php

// This code looks for all possible solutions of a given sudoku grid.

/**
 * Displays grid in terminal
 */
function displaygrid($grid)
{
    for ($i = 0; $i < 9; $i++) {
        for ($j = 0; $j < 9; $j++) {
            echo $grid[$i][$j];
            echo "  ";
        }
        echo "\n";
    }
}

/**
 * Displays a line in terminal (for debug purposes)
 */
function displayLine($line)
{
    for ($i = 0; $i < count($line); $i++) {
        echo $line[$i];
        echo "  ";
    }
    echo "\n";
}

/**
 * Determines if a grid follows the usual sudoku rules
 */
function isGridOK($grid)
{
    // Browse each row, extract non-zero values and check for duplicates
    for ($i = 0; $i < 9; $i++) {
        $row = [];
        for ($j = 0; $j < 9; $j++) {
            if ($grid[$i][$j] != 0) {
                $row[] = $grid[$i][$j];
            }
        }

        // If the number of unique values and the number of values are different
        if (count(array_unique($row)) != count($row)) {
            return false;
        }
    }
    // Browse each column and extract non-zero values
    for ($i = 0; $i < 9; $i++) {
        $col = array();
        for ($j = 0; $j < 9; $j++) {
            if ($grid[$j][$i] != 0) {
                $col[] = $grid[$j][$i];
            }
        }
        // If the number of unique values and the number of values are different
        if (count(array_unique($col)) != count($col)) {
            return false;
        }
    }

    // Check every 3x3 block
    for ($s = 0; $s < 9; $s++) { // 9 blocks
        $bloc = array();
        $ligneBloc = (3 * $s) % 9;
        $colonneBloc = 3 * (intdiv($s, 3));
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($grid[$ligneBloc + $i][$colonneBloc + $j] != 0) {
                    $bloc[] = $grid[$ligneBloc + $i][$colonneBloc + $j];
                }
            }
        }
        // If the number of unique values and the number of values are different
        if (count(array_unique($bloc)) != count($bloc)) {
            return false;
        }
    }

    return true;
}

function isGridFull($grid)
{
    for ($i = 0; $i < 9; $i++) {
        for ($j = 0; $j < 9; $j++) {
            if ($grid[$i][$j] == 0) {
                return false;
            }
        }
    }
    return true;
}

function solve($grid, $level)
{
    global $nbSolution;
    for ($i = 0; $i < 9; $i++) {
        for ($j = 0; $j < 9; $j++) {
            if ($grid[$i][$j] == 0) { // Here is the loop we'll get out of
                for ($k = 1; $k < 10; $k++) {
                    $grid[$i][$j] = $k;
                    if (isGridOK($grid)) {
                        if (isGridFull($grid)) {
                            $nbSolution++;
                            
                            echo "Solution number ", $nbSolution, " is: \n";
                            displaygrid($grid);
                            echo "Found at level ", $level, ".\n";
                            echo "Other solutions being computed...";
                            echo "\n";
                            
                            // echo "Going up! \n";
                            return;
                        } else {
                            $level++;
                            // echo "Going deeper! \n";
                            solve($grid, $level); // recursion!
                            $level--;
                            // echo "Going up! \n";
                        }
                    }
                }
                break 2; // Leaving the double loop without checking the other squares
            }
        }
    }
}


$sudokuOri = [
    [3, 0, 0, 0, 0, 9, 0, 0, 0],
    [0, 0, 0, 0, 7, 0, 5, 0, 0],
    [0, 0, 0, 8, 0, 0, 0, 1, 7],
    [0, 0, 6, 0, 2, 0, 0, 0, 0],
    [1, 0, 0, 0, 0, 3, 0, 0, 0],
    [0, 0, 0, 0, 0, 5, 0, 4, 9],
    [0, 2, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 5, 0, 6, 0, 1, 0, 0],
    [0, 8, 4, 3, 0, 7, 0, 2, 0]
];

/* Corresponding unique solution is:
3  1  7  2  5  9  4  6  8
8  6  2  4  7  1  5  9  3
4  5  9  8  3  6  2  1  7
5  9  6  7  2  4  8  3  1
1  4  8  6  9  3  7  5  2
2  7  3  1  8  5  6  4  9
9  2  1  5  4  8  3  7  6
7  3  5  9  6  2  1  8  4
6  8  4  3  1  7  9  2  5
*/

/* Another sudoku to try:
$sudokuOri = [
    [2, 0, 6, 0, 0, 7, 3, 0, 0],
    [0, 3, 0, 0, 0, 0, 0, 0, 0],
    [0, 9, 0, 3, 0, 1, 0, 4, 0],
    [3, 0, 0, 0, 7, 0, 0, 2, 5],
    [0, 0, 0, 4, 1, 9, 0, 0, 0],
    [1, 6, 0, 0, 5, 0, 0, 0, 9],
    [0, 5, 0, 7, 0, 6, 0, 1, 0],
    [0, 0, 0, 0, 0, 0, 0, 5, 0],
    [0, 0, 1, 9, 0, 0, 8, 0, 3]
];
*/

/* And its corresponding unique solution:

$filledSudoku = [
    [2, 1, 6, 5, 4, 7, 3, 9, 8],
    [5, 3, 4, 8, 9, 2, 6, 7, 1],
    [7, 9, 8, 3, 6, 1, 5, 4, 2],
    [3, 4, 9, 6, 7, 8, 1, 2, 5],
    [8, 2, 5, 4, 1, 9, 7, 3, 6],
    [1, 6, 7, 2, 5, 3, 4, 8, 9],
    [9, 5, 3, 7, 8, 6, 2, 1, 4],
    [6, 8, 2, 1, 3, 4, 9, 5, 7],
    [4, 7, 1, 9, 2, 5, 8, 6, 3]];
    */

echo "Original grid is: \n";
displaygrid($sudokuOri);

echo "\nSolving...\n\n";
$level = 0;
$nbSolution = 0;
solve($sudokuOri, $level);

if ($nbSolution == 0) {
    echo "No solution!\n\n";
} else {
    echo $nbSolution, " solution(s) found.\n\n";
}

echo "Thank you all!\n";

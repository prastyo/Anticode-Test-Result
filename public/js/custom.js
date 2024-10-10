/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(".modal").draggable({
    handle: ".modal-header"
});

$(document).on({
    ajaxStart: function () {
        $(".loading-state").show();
    },
    ajaxStop: function () {
        $(".loading-state").hide();
    }
});

$('[data-toggle="datepicker"]').datepicker({
    autoHide: true,
});

// Function to generate a gradient color between two RGB colors
function generateGradient(color1, color2, alpha) {
    let rgb1 = color1.match(/\d+/g).map(Number); // Get RGB values from color1
    let rgb2 = color2.match(/\d+/g).map(Number); // Get RGB values from color2
    let newColor = rgb1.map((v, i) => Math.round(v * 0.5 + rgb2[i] * 0.5)); // Calculate the average RGB values for the gradient
    return `rgba(${newColor[0]}, ${newColor[1]}, ${newColor[2]}, ${alpha})`; // Return the gradient color in rgba format
}

// Main function to generate the color list
function getColorPalette(input, alpha = 1) {
    const baseColors = [
        [103, 119, 239],  // primary
        [58, 186, 244],   // info
        [71, 195, 99],    // success
        [252, 84, 75],    // danger
        [255, 193, 7],    // warning
        [0, 92, 169],     // cobalt
        [156, 136, 255]   // lavender
    ];

    // Convert baseColors array into an array of rgba colors
    const palette = baseColors.map(rgb => `rgba(${rgb[0]}, ${rgb[1]}, ${rgb[2]}, ${alpha})`);

    // Array to store the final color results
    let resultColors = [];

    for (let i = 0; i < input; i++) {
        let color1, color2;

        if (i < palette.length) {
            // Colors 1 to 5 use colors from the palette
            resultColors.push(palette[i]);
        } else if (i < 2 * palette.length) {
            // Colors 6 to 10 are gradient colors from the palette
            color1 = palette[i % palette.length];
            color2 = palette[(i + 1) % palette.length];
            resultColors.push(generateGradient(color1, color2, alpha));
        } else {
            // Colors 11 and onwards are gradients from colors 6 to 10
            color1 = resultColors[i - palette.length];
            color2 = resultColors[(i - palette.length + 1) % palette.length];
            resultColors.push(generateGradient(color1, color2, alpha));
        }
    }

    return resultColors;
}

$('.date').mask('00-00-0000', { placeholder: "dd-mm-yyyy" });
$('.time').mask('00:00', { placeholder: "hh:mm" });
$('.year').mask('0000', { placeholder: "yyyy" });
$('.money').mask('#.##0', {reverse: true});
$('.number').mask('0#');
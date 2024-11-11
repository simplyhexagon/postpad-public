#!/usr/bin/python
# Python script to minify CSS
import re

def minify_css(input_file, output_file):
    # Load the CSS file
    with open(input_file, 'r') as f:
        css_content = f.read()

    # Remove comments
    css_content = re.sub(r'/\*.*?\*/', '', css_content, flags=re.DOTALL)

    # Remove whitespace and newlines
    css_content = re.sub(r'\s+', ' ', css_content)

    # Remove unnecessary spaces around characters
    css_content = re.sub(r'\s*([{}:;,])\s*', r'\1', css_content)

    # Save the minified CSS to the output file
    with open(output_file, 'w') as f:
        f.write(css_content)

if __name__ == "__main__":
    input_file = "./htroot/public/res/style.css"  # Replace with your input CSS file
    output_file = "./htroot/public/res/style.min.css"  # Replace with your desired output file

    minify_css(input_file, output_file)

    print(f"CSS minification completed. Minified CSS saved to {output_file}")

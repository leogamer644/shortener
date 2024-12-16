from flask import Flask, redirect, request, abort

app = Flask(name)

#Load the URL mappings from urls.txt
def loadurlmappings():
    mappings = {}
    try:
        with open('urls.txt', 'r') as file:
            for line in file:
                short, long = line.strip().split(' ')
                mappings[short] = long
    except FileNotFoundError:
        print("urls.txt not found. Ensure it exists and is properly formatted.")
    return mappings

urlmappings = loadurl_mappings()

@app.route('/<short_code>')
def redirect_to_url(short_code):
    # Check if the short code exists in mappings
    if short_code in url_mappings:
        return redirect(url_mappings[short_code], code=302)
    else:
        abort(404)  # Short URL not found

@app.route('/reload', methods=['POST'])
def reload_mappings():
    global url_mappings
    url_mappings = load_url_mappings()
    return "URL mappings reloaded.", 200

if __name == '__main':
    app.run(host='0.0.0.0', port=8080)
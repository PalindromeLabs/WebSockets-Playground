#!/usr/bin/env python3

import argparse
import websocket

def parse_args():
    parser = argparse.ArgumentParser(description="Simple WebSockets Test Tool")
    parser.add_argument("-v", "--verbose", action="store_true",
                        help="Enable verbose tracing of communications")
    parser.add_argument("-u", "--url",
                        help="URL to connect to")
    parser.add_argument("-n", "--no-encryption", action="store_true",
                        help="Connect using ws://, not wss://")
    parser.add_argument("-s", "--subprotocols", type=str, #nargs="*",
                        help="Set subprotocols")
    parser.add_argument("-m", "--message", default="hiworld", type=str, nargs="*",
                        help="Preset custom message to send over WebSocket connection")
    return parser.parse_args()

def send_a_message(arguments):
    wsurl = ""
    options = {}
    if arguments.url.find("http://") == 0 or arguments.url.find("https://") == 0:
        raise Exception("URLs should not contain http:// or https:// - \
        please read the README and clean these from the input URLs")
    # Set the ws:// or wss:// schema
    if arguments.no_encryption:
        wsurl = "ws://" + arguments.url
    else:
        wsurl = "wss://" + arguments.url
    if arguments.subprotocols:
        options["subprotocols"] = {arguments.subprotocols}
    # Set default timeout to 3 seconds
    options["timeout"] = 3
    ws = websocket.create_connection(wsurl, **options)

    # Assume only 1 message is provided as input, not a list
    ws.send(arguments.message)
    print("Sending: " + arguments.message)
    result = ws.recv()
    print("Received '%s'" % result)

    ws.close()

def main():
    args = parse_args()
    if args.verbose:
        websocket.enableTrace(True)

    ws = websocket.WebSocket(skip_utf8_validation=True)

    if args.url is not None:
        send_a_message(args)

if __name__ == "__main__":
    try:
        main()
    except Exception as e:
        print(e)

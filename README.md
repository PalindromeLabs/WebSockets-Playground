# WebSockets Playground

This repository is designed to jumpstart multiple local WebSocket servers
in parallel for testing purposes. This repository was originally designed
for WebSocket server fingerprint testing.

## Usage

### Dependencies

Before running the playground script, install the following:
- git (to download repositories)
- Python 3 (for websockets and Tornado)
- npm, NodeJS (for ws and faye-websocket-node)
- make (for uWebSockets)
- go (for Gorilla)
- Java, mvn (for Java Spring Boot)
- PHP, composer (for Ratchet)

### Setup

Running the bash script `./run_ws_playground.sh` should start the local
WebSocket servers outlined in the table below.
A small `playground_send.py` file is included to send messages to the servers
to verify they are listening and responding.

### Tip

If you are running this script more than once, you will probably need to kill the previously started examples with:
```
# First list the running processes with ps
ps aux
# Manually identify the process IDs for node, golang WS examples
# Then kill each active process to avoid conflicts when script is rerun
kill <PID #>
```

## Table of WebSocket Servers

| WebSocket Server | Language | Port number | URL |
| :---- | :---------- | :---------- | :---------- |
| [ws](https://github.com/websockets/ws/tree/master/examples/server-stats) | JS | 8081 | 127.0.0.1:8081 |
| [faye-websocket-node](https://github.com/faye/faye-websocket-node) | JS | 7000 | 127.0.0.1:7000 |
| [Gorilla](https://github.com/gorilla/websocket) | Go | 8084 | 127.0.0.1:8084/echo |
| [uWebSockets](https://github.com/uNetworking/uWebSockets) | C++ | 9001 | 127.0.0.1:9001 |
| [Java Spring Boot](https://github.com/ralscha/spring4ws-demos) | Java | 8080 | 127.0.0.1:8080/stomp |
| [Python websockets](https://github.com/aaugustin/websockets) | Python | 8765 | 127.0.0.1:8765 |
| [Ratchet](https://github.com/ratchetphp/Ratchet) | PHP | 8085 | 127.0.0.1:8085 |
| [Tornado](https://github.com/tornadoweb/tornado) | Python | 3000 | 127.0.0.1:3000 |

## Online WebSocket Servers

The following public WebSocket servers can be used for quick tests, but
larger testing loads should be performed on local servers.

- [Ratchet](https://github.com/ratchetphp/Ratchet) demo: http://socketo.me/demo
- [Socket.io](https://github.com/socketio/socket.io) demo: https://socket.io/demos/chat/
- [Faye websocket](https://github.com/faye/faye-websocket-node) real-world use case: https://firepad.io/examples/

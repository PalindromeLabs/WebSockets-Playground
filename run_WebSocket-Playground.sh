#!/bin/bash

# To Do: Add these common WebSocket servers
# Phoenix (Elixir): https://github.com/phoenixframework/phoenix
# Cowboy (Erlang): https://github.com/ninenines/cowboy
# Workerman (PHP): https://github.com/walkor/Workerman
# Jetty (Java): https://github.com/eclipse/jetty.projects

download(){
  git clone https://github.com/websockets/ws/
  git clone https://github.com/faye/faye-websocket-node
  git clone https://github.com/gorilla/websocket
  git clone https://github.com/uNetworking/uWebSockets
  git clone https://github.com/ralscha/spring4ws-demos
  git clone https://github.com/aaugustin/websockets
  git clone --recursive https://github.com/boostorg/boost
  git clone https://github.com/ilkerkesen/tornado-websocket-client-example
#  git clone https://github.com/hkp22/php-websocket-example # modified this default repo
  git clone https://github.com/warmcat/libwebsockets
}

install_deps(){
  # Install ws dependencies
  cd ws
  npm install
  cd examples/server-stats
  npm install
  # Change example to use port 8081, so prevent port conflicts with other examples
  sed -i 's/8080/8081/' index.js
  cd ../../..

  # Install faye dependencies
  cd faye-websocket-node
  npm install
  cd ..

  # Install Gorilla
  go get github.com/gorilla/websocket
  # Change local repo example to use port 8084, so prevent port conflicts with other examples
  sed -i 's/8080/8084/' websocket/examples/echo/server.go

  # Install uWebSockets
  # Assumes that C++ build tools are installed
  git clone --recurse-submodules -j8 https://github.com/uNetworking/uWebSockets
  cd uWebSockets
  make examples
  cd ..

  # Install spring4ws-demos
  # Assume maven is installed
  cd spring4ws-demos
  rm -r ./src/main/java/ch/rasc/s4ws/twitter
  mvn package
  cd ..

  # Install Python websockets modules
  pip3 install websockets --user

  # Install Ratchet
  # Assumes that PHP is installed
  cd php-websocket-example
  curl -sS https://getcomposer.org/installer | php
  composer.phar install
  # If using git repo, need to change the port. But currently using modified repo
#  sed -i 's/8080/8085/' server.php
  cd ..

  cd boost
  ./bootstrap.sh
  ./b2
  cd ..

  cd tornado-websocket-client-example
  pip3 install -r requirements.txt --user
  cd ..
}

start_servers(){
  # Run ws example on port 8081
  node ws/examples/server-stats/index.js &

  # Run faye example on port 7000
  node faye-websocket-node/examples/server.js &

  # Run Gorilla WebSocket example on port 8084
  cd websocket
  go run examples/echo/server.go &
  cd ..

  # Run uWebSockets echo example on port 9001
  cd uWebSockets
  ./EchoServer &
  cd ..

  # Run Java Spring boot demo on port 8080
  cd spring4ws-demos
  java -jar target/spring4ws-demos.jar &
  cd ..

  # Run Python websockets echo on port 8765
  python3 websockets/example/echo.py &

  # Run Ratchet chat room on port 8085
  cd php-websocket-example
  php server.php &

  cd ..

  # Run boost beast (not implemented yet)
  cd boost
  cd ..

  # Run Tornado on port
  cd tornado-websocket-client-example
  python3 server.py
  cd ..

  # sleep for 10 seconds to let servers boot up
  sleep 10
}

ping_server(){
  server="$1"
  python3 playground_send.py -u $server -n
  echo ""
}

ping_local(){
  echo ">>>Ping ws server stats example"
  ping_server ws://127.0.0.1:8081
  echo ">>>ping faye echo example"
  ping_server 127.0.0.1:7000
  echo ">>>ping Gorilla echo example"
  ping_server 127.0.0.1:8084/echo
  echo ">>>ping uWebSockets echo example"
  ping_server 127.0.0.1:9001
  echo ">>>ping Java Spring demo"
  ping_server 127.0.0.1:8080/stomp
  echo ">>>ping Python websockets echo example"
  ping_server 127.0.0.1:8765
  echo ">>>ping Ratchet chat example"
  ping_server 127.0.0.1:8085
  echo ">>>ping Tornado example"
  ping_server 127.0.0.1:3000
}

ping_external(){
  echo ">>>ping Ratchet example"
  ping_server socketo.me/chat
  echo ">>>ping faye real-world example"
  python3 playground_send.py -u s-usc1c-nss-244.firebaseio.com/.ws
  echo ""
  echo ">>>ping libwebsockets demo"
  python3 playground_send.py --subprotocols "lws-status" -u libwebsockets.org
}

download
install_deps
start_servers
ping_local
ping_external

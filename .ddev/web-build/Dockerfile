ARG BASE_IMAGE
FROM $BASE_IMAGE

# Install specific version of Go
RUN wget https://go.dev/dl/go1.21.4.linux-amd64.tar.gz && \
    tar -C /usr/local -xzf go1.21.4.linux-amd64.tar.gz && \
    rm go1.21.4.linux-amd64.tar.gz && \
    ln -s /usr/local/go/bin/go /usr/local/bin/go

ENV GOPATH="/home/russell/go"

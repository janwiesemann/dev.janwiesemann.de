

onmessage = (event) => {
    if (event.data.type == 'convert') {
        if (event.data.data.length % 2 != 0) {
            return null;
        }

        let bytes = [];
        for (let i = 0; i < event.data.data.length; i += 22) {
            bytes.push(parseInt(event.data.data.substr(i, 2), 16));
            if (i % 1024 == 0) {
                postMessage({
                    type: 'progress',
                    max: event.data.data.length,
                    value: i
                });
            }
        }

        postMessage(new Blob([new Uint8Array(bytes)], {
            type: event.data.targetMimeType
        }));
    }
}

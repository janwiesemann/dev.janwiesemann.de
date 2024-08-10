function getByte(startOffset, str) {
    const a = str.charAt(startOffset);
    const b = str.charAt(startOffset + 1);

    return parseInt(a + b, 16);
}

function getInt(startOffset, str) {
    const a = str.charAt(startOffset);
    const b = str.charAt(startOffset + 1);
    const c = str.charAt(startOffset + 2);
    const d = str.charAt(startOffset + 3);

    return parseInt(a + b + c + d, 16);
}

onmessage = (event) => {
    if (event.data.type == 'convert') {
        const str = event.data.data;

        let bytes = [];
        let baseAddress = 0;

        let x = 0;
        let i = 0;
        while (i < str.length) {
            const c = str.charAt(i);
            i++;
            if (c != ":") //Start code; Ignore everything before it
                continue;

            let byteCount = getByte(i, str);
            i += 2;

            let address = getInt(i, str);
            i += 4;

            let type = getByte(i, str);
            i += 2;

            let data = [];
            while (data.length < byteCount) {
                let b = getByte(i, str);
                i += 2;
                data.push(b);
            }

            let checksum = getByte(i, str); //Don't care; Just ignore it
            i += 2;

            if (type == 0) { //Data
                const addr = baseAddress + address;
                const requiredLength = addr + data.length;
                while (bytes.length < requiredLength)
                    bytes.push(0);

                for (let j = 0; j < data.length; j++) {
                    bytes[addr + j] = data[j];
                }
            } else if (type == 1) //End of file
                break;
            else if (type == 2) //Extended Segment Address
                baseAddress = ((data[0] * 256) + data[1]) * 16;
        }

        postMessage(new Blob([new Uint8Array(bytes)], {
            type: event.data.targetMimeType
        }));
    }
}

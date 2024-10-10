<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Budi Prastyo <budi@prastyo.com>">
    <title>@yield('title')</title>
    <style>
        #typing-area::after {
            content: '|';
            animation: blink 0.7s infinite;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div id="typing-area" style="white-space: pre-wrap;"></div>
    <script>
        const element = document.querySelector('#typing-area');

        // Teks yang akan diketik
        let textToType = `@yield('message')`;
        const delayTime = 1000; // Waktu tunda sebelum mengetik dimulai

        let currentIndex = 0;
        let hasErrorTyped = false;
        let errorIndexes = []; // Array untuk menyimpan posisi acak kesalahan
        let maxErrors = 3; // Jumlah maksimal kesalahan yang diinginkan

        // Peta tata letak keyboard QWERTY
        const keyboardMap = {
            'q': ['w', 'a'],
            'w': ['q', 'e', 's'],
            'e': ['w', 'r', 'd'],
            'r': ['e', 't', 'f'],
            't': ['r', 'y', 'g'],
            'y': ['t', 'u', 'h'],
            'u': ['y', 'i', 'j'],
            'i': ['u', 'o', 'k'],
            'o': ['i', 'p', 'l'],
            'p': ['o'],
            'a': ['q', 's', 'z'],
            's': ['a', 'd', 'w', 'x'],
            'd': ['s', 'f', 'e', 'c'],
            'f': ['d', 'g', 'r', 'v'],
            'g': ['f', 'h', 't', 'b'],
            'h': ['g', 'j', 'y', 'n'],
            'j': ['h', 'k', 'u', 'm'],
            'k': ['j', 'l', 'i'],
            'l': ['k', 'o'],
            'z': ['a', 'x'],
            'x': ['z', 'c', 's'],
            'c': ['x', 'v', 'd'],
            'v': ['c', 'b', 'f'],
            'b': ['v', 'n', 'g'],
            'n': ['b', 'm', 'h'],
            'm': ['n', 'j']
        };

        // Fungsi untuk menghasilkan posisi acak kesalahan
        function generateErrorPositions() {
            let positions = [];
            while (positions.length < maxErrors) {
                const randomPos = Math.floor(Math.random() * textToType.length);
                if (!positions.includes(randomPos)) {
                    positions.push(randomPos);
                }
            }
            return positions;
        }

        // Mendapatkan daftar posisi acak kesalahan
        errorIndexes = generateErrorPositions();

        // Fungsi untuk memilih huruf typo dari huruf yang berdekatan pada keyboard
        function getTypoChar(correctChar) {
            const lowerChar = correctChar.toLowerCase();
            if (keyboardMap[lowerChar]) {
                const nearbyKeys = keyboardMap[lowerChar];
                const randomIndex = Math.floor(Math.random() * nearbyKeys.length);
                return nearbyKeys[randomIndex];
            }
            return correctChar; // Jika tidak ada di peta keyboard, kembalikan huruf asli
        }

        // Fungsi untuk menghasilkan kecepatan acak
        function getRandomTypingSpeed(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function typeLetter() {
            const currentText = element.innerHTML;

            // Mengecek apakah indeks saat ini berada di posisi kesalahan acak
            if (errorIndexes.includes(currentIndex) && !hasErrorTyped) {
                // Dapatkan huruf yang salah (typo) dari huruf yang berdekatan
                const typoChar = getTypoChar(textToType[currentIndex]);
                element.innerHTML += typoChar;
                setTimeout(removeTypo, getRandomTypingSpeed(500, 1000)); // Menunggu sebelum menghapus huruf yang salah
                hasErrorTyped = true; // Mengatur flag kesalahan
            } else {
                element.innerHTML = currentText + textToType[currentIndex]; // Menambahkan huruf yang benar

                currentIndex++;
                hasErrorTyped = false; // Mengizinkan kesalahan berikutnya terjadi

                if (currentIndex < textToType.length) {
                    setTimeout(typeLetter, getRandomTypingSpeed(50,
                        300)); // Melanjutkan mengetik huruf berikutnya dengan kecepatan acak
                }
            }
        }

        function removeTypo() {
            const currentText = element.innerHTML;
            element.innerHTML = currentText.slice(0, -1); // Menghapus huruf yang salah
            setTimeout(typeLetter, getRandomTypingSpeed(50,
                300)); // Lanjutkan mengetik setelah menghapus kesalahan dengan kecepatan acak
        }

        // Memulai efek mengetik setelah delay
        setTimeout(typeLetter, delayTime);
    </script>
</body>

</html>

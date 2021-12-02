require("./bootstrap");

import Alpine from "alpinejs";
import Snackbar from "node-snackbar";

window.Alpine = Alpine;

Alpine.start();

window.addEventListener("file_requested", (event) => {
    Snackbar.show({
        text: "File request sent successfully.",
        pos: "top-right",
        duration: 10000,
    });
});

window.addEventListener("request_exists", (event) => {
    Snackbar.show({
        text: "File already requested. Go to File Requests to view status.",
        pos: "top-right",
        duration: 10000,
    });
});

window.addEventListener("access_code_generated", (event) => {
    Snackbar.show({
        text: "Access granted and access code generated successfully.",
        pos: "top-right",
        duration: 10000,
    });
});

window.addEventListener("request_denied", (event) => {
    Snackbar.show({
        text: "Access to file or document denied.",
        pos: "top-right",
        duration: 10000,
    });
});

window.addEventListener("file_deleted", (event) => {
    Snackbar.show({
        text: "File, file requests and access to the file are now deleted.",
        pos: "top-right",
        duration: 10000,
    });
});

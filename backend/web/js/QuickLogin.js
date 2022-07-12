function DisplayQuickLogin()
{
    var Div = document.getElementById("quickLoginCode");
    if (!Div)
        return;

    if (!Div.hasAttribute("data-done"))
    {
        Div.className = "QuickLogin";
        Div.setAttribute("data-done", "0");
    }
    else if (Div.getAttribute("data-done") == "1")
        return;

    var Mode = Div.getAttribute("data-mode");
    var Purpose = Div.getAttribute("data-purpose");
    var ServiceId = Div.hasAttribute("data-serviceId") ? Div.getAttribute("data-serviceId") : "";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if (xhttp.readyState === 4)
        {
            if (xhttp.status === 200)
            {
                var Data = JSON.parse(xhttp.responseText);
                if (Data.text)
                {
                    var Pre = document.getElementById("quickLoginPre");

                    if (!Pre)
                    {
                        Pre = document.createElement("PRE");
                        Pre.setAttribute("id", "quickLoginPre");
                        Div.appendChild(Pre);
                    }

                    Pre.innerText = Data.text;

                    var Img = document.getElementById("quickLoginImg");
                    if (Img)
                        Img.parentNode.removeChild(Img);
                }
                else
                {
                    var Img = document.getElementById("quickLoginImg");

                    if (!Img)
                    {
                        Img = document.createElement("IMG");
                        Img.setAttribute("id", "quickLoginImg");
                        Div.appendChild(Img);
                    }

                    if (Data.base64)
                        Img.setAttribute("src", "data:" + Data.contentType + ";base64," + Data.base64);
                    else if (Data.src)
                        Img.setAttribute("src", Data.src);

                    //Img.setAttribute("width", '100%');
                    //Img.setAttribute("height", Data.height);

                    var Pre = document.getElementById("quickLoginPre");
                    if (Pre)
                        Pre.parentNode.removeChild(Pre);
                }

                LoginTimer = window.setTimeout(function () { DisplayQuickLogin(); }, 2000);
            }
            else
                ShowError(xhttp);
        };
    }

    var Uri = window.location.protocol + "//" + FindNeuronDomain() + "/QuickLogin";

    xhttp.open("POST", Uri, true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(
        {
            "serviceId": ServiceId,
            "tab": TabID,
            "mode": Mode,
            "purpose": Purpose
        }));
}

function SignatureReceivedBE(Empty)
{
    var div = $('#quickLoginCode').attr('data-action');

    qrScanReceived();
    // Function called when login has been performed, and login credentials have been sent to the backend.
    // Here, the client can choose to refresh the GUI, or wait for events frmo the back-end itself. Argument
    // will be empty.
}

function SignatureReceived(Data)
{
    window.clearTimeout(LoginTimer);

    var Div = document.getElementById("quickLoginCode");
    if (!Div)
        return;

    Div.setAttribute("data-done", "1");

    var Img = document.getElementById("quickLoginImg");
    if (!Img)
    {
        Img = document.getElementById("quickLoginPre");
        if (!Img)
            return;
    }

    Div = Img.parentNode;
    Div.removeChild(Img);

    var H2 = document.createElement("H2");
    Div.appendChild(H2);
    H2.innerText = "Successfully logged in.";

    var TBody = AddTable(Div, "Identity of user.");

    AddRow(TBody, "Id", Data.Id, true);
    AddRow(TBody, "Provider", Data.Provider, true);
    AddRow(TBody, "State", Data.State, true);
    AddRow(TBody, "Created", new Date(1000 * Data.Created), false);

    if (Data.Updated)
        AddRow(TBody, "Updated", new Date(1000 * Data.Updated), false);

    AddRow(TBody, "From", new Date(1000 * Data.From), false);
    AddRow(TBody, "To", new Date(1000 * Data.To), false);
    AddRow(TBody, "Client Key Name", Data.ClientKeyName, true);

    if (Data.HasClientPublicKey)
        AddRow(TBody, "Client Public Key", Data.ClientPubKey, true);

    if (Data.HasClientSignature)
        AddRow(TBody, "Client Signature", Data.ClientSignature, true);

    AddRow(TBody, "Server Signature", Data.ServerSignature, true);

    TBody = AddTable(Div, "User meta-data.");

    Object.keys(Data.Properties).forEach(Key =>
    {
        AddRow(TBody, Key, Data.Properties[Key], false);
    });

    var i, c = Data.Attachments.length;

    for (i = 0; i < c; i++)
    {
        var Attachment = Data.Attachments[i];

        TBody = AddTable(Div, "Attachment " + (i + 1));

        AddRow(TBody, "Id", Attachment.Id, true);
        AddRow(TBody, "Content-Type", Attachment.ContentType, true);
        AddRow(TBody, "File Name", Attachment.FileName, true);
        AddRow(TBody, "Signature", Attachment.Signature, true);
        AddRow(TBody, "Timestamp", new Date(1000 * Attachment.Timestamp), false);

        var Tr = document.createElement("TR");
        TBody.appendChild(Tr);

        var Td = document.createElement("TD");
        Td.setAttribute("colspan", "2");
        Td.setAttribute("style", "text-align:center");
        Tr.appendChild(Td);

        if (Attachment.Url.substr(0, 8) == "https://")
        {
            var Img = document.createElement("IMG");
            Img.setAttribute("src", window.location.protocol + "//" + FindNeuronDomain() + "/QuickLogin/" + Data.Key + "/" + Attachment.Url.substr(8));
            Td.appendChild(Img);
        }
    }
}

function AddTable(Div, Title)
{
    var Table = document.createElement("TABLE");
    Div.appendChild(Table);

    var THead = document.createElement("THEAD");
    Table.appendChild(THead);

    var Tr = document.createElement("TR");
    THead.appendChild(Tr);

    var Th = document.createElement("TH");
    Th.setAttribute("colspan", "2");
    Th.innerText = Title;
    Tr.appendChild(Th);

    var TBody = document.createElement("TBODY");
    Table.appendChild(TBody);

    return TBody;
}

function AddRow(TBody, Name, Value, Code)
{
    var Tr = document.createElement("TR");
    TBody.appendChild(Tr);

    var Td = document.createElement("TD");
    Td.innerText = Name;
    Tr.appendChild(Td);

    Td = document.createElement("TD");
    Tr.appendChild(Td);

    if (Code)
    {
        var Code = document.createElement("CODE");
        Code.innerText = Value;
        Td.appendChild(Code);
    }
    else
        Td.innerText = Value;
}

function SetMode(Mode)
{
    var Element = document.getElementById("quickLoginCode");
    var PrevMode = Element.getAttribute("data-mode");
    Element.setAttribute("data-mode", Mode);

    Element = document.getElementById("quickLoginPre");
    if (Element)
        Element.parentElement.removeChild(Element);

    Element = document.getElementById("quickLoginImg");
    if (Element)
        Element.parentElement.removeChild(Element);

    Element = document.getElementById("TextModeButton");
    Element.setAttribute("class", Mode == "text" ? "posButtonPressed" : "posButton");

    Element = document.getElementById("Base64ModeButton");
    Element.setAttribute("class", Mode == "base64" ? "posButtonPressed" : "posButton");

    Element = document.getElementById("ImageModeButton");
    Element.setAttribute("class", Mode == "image" ? "posButtonPressed" : "posButton");

    Element = Element.parentNode.firstChild;
    while (Element && Element.tagName !== "PRE")
        Element = Element.nextSibling;

    Element.innerText = Element.innerText.replace("data-mode=\"" + PrevMode + "\"", "data-mode=\"" + Mode + "\"");

    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;

    window.clearTimeout(LoginTimer);
    DisplayQuickLogin();
}

var LoginTimer = window.setTimeout(function () { DisplayQuickLogin(); }, 100);

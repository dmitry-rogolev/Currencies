const chars = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

function id(prefix = "id_", length = 60)
{
    var str = prefix;

    for (var i = 0; i < length; i++)
    {
        str += chars[rand(0, chars.length - 1)];
    }

    return str;
}

function rand(min = 0, max = 100)
{
    return Math.floor(Math.random() * (max - min)) + min;
}

export { id, rand };

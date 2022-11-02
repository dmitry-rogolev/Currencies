class Route
{
    #path;

    #component;

    #name;

    #children;

    #beforeEnter;

    constructor(path, component)
    {
        if (typeof path == "string")
            this.#path = path.startsWith("/") ? path : "/".concat(path);
        else 
            throw new Error("path должен быть типом String");

        this.#component = component;
    }

    static new(path = "", component)
    {
        return new Route(path, component);
    }

    name(name)
    {
        if (typeof name == "string")
        {
            this.#name = name;
        }

        return this;
    }

    children(childs = [])
    {
        this.#children = childs;

        return this;
    }

    beforeEnter(callback)
    {
        this.#beforeEnter = callback;

        return this;
    }

    get()
    {
        return {
            path: this.#path, 
            name: this.#name, 
            component: this.#component, 
            children: this.#children, 
            beforeEnter: this.#beforeEnter, 
        };
    }
}

export default Route;

function functionList()
{
    var gridView = document.getElementById("gridView");
    var listView = document.getElementById("listView");
    if (gridView.style.display === "none")
    {
        gridView.style.display = "block";
    }
    if (gridView.style.display === "none")
    {
        listView.style.display = "block";
    }
    else
    {
        listView.style.display = "none";
    }
};

function functionGrid()
{
    var gridView = document.getElementById("gridView");
    var listView = document.getElementById("listView");
    if (listView.style.display === "none")
    {
        listView.style.display = "block";
    }
    if (listView.style.display === "none")
    {
        gridView.style.display = "block";
    }
    else
    {
        gridView.style.display = "none";
    }
};
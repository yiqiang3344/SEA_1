var template = '<div>{{title}}</div> <div> {{#list}} <span>{{.}}</span> {{/list}} {{^list}} <span>空</span> {{/list}} </div>';
function m_print(){
    var html = Mustache.to_html(template, params);
    document.write(html);
}
const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"pulse":{"uri":"pulse","methods":["GET","HEAD"]},"telescope":{"uri":"telescope\/{view?}","methods":["GET","HEAD"],"wheres":{"view":"(.*)"},"parameters":["view"]},"livewire.update":{"uri":"livewire\/update","methods":["POST"]},"livewire.upload-file":{"uri":"livewire\/upload-file","methods":["POST"]},"livewire.preview-file":{"uri":"livewire\/preview-file\/{filename}","methods":["GET","HEAD"],"parameters":["filename"]},"laratrust.permissions.index":{"uri":"laratrust\/permissions","methods":["GET","HEAD"]},"laratrust.permissions.create":{"uri":"laratrust\/permissions\/create","methods":["GET","HEAD"]},"laratrust.permissions.store":{"uri":"laratrust\/permissions","methods":["POST"]},"laratrust.permissions.edit":{"uri":"laratrust\/permissions\/{permission}\/edit","methods":["GET","HEAD"],"parameters":["permission"]},"laratrust.permissions.update":{"uri":"laratrust\/permissions\/{permission}","methods":["PUT","PATCH"],"parameters":["permission"]},"laratrust.roles.index":{"uri":"laratrust\/roles","methods":["GET","HEAD"]},"laratrust.roles.create":{"uri":"laratrust\/roles\/create","methods":["GET","HEAD"]},"laratrust.roles.store":{"uri":"laratrust\/roles","methods":["POST"]},"laratrust.roles.show":{"uri":"laratrust\/roles\/{role}","methods":["GET","HEAD"],"parameters":["role"]},"laratrust.roles.edit":{"uri":"laratrust\/roles\/{role}\/edit","methods":["GET","HEAD"],"parameters":["role"]},"laratrust.roles.update":{"uri":"laratrust\/roles\/{role}","methods":["PUT","PATCH"],"parameters":["role"]},"laratrust.roles.destroy":{"uri":"laratrust\/roles\/{role}","methods":["DELETE"],"parameters":["role"]},"laratrust.roles-assignment.index":{"uri":"laratrust\/roles-assignment","methods":["GET","HEAD"]},"laratrust.roles-assignment.edit":{"uri":"laratrust\/roles-assignment\/{roles_assignment}\/edit","methods":["GET","HEAD"],"parameters":["roles_assignment"]},"laratrust.roles-assignment.update":{"uri":"laratrust\/roles-assignment\/{roles_assignment}","methods":["PUT","PATCH"],"parameters":["roles_assignment"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"index":{"uri":"\/","methods":["GET","HEAD"]},"store":{"uri":"\/","methods":["POST"]},"about":{"uri":"about","methods":["GET","HEAD"]},"status.index":{"uri":"status","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"login.submit":{"uri":"login","methods":["POST"]},"forgot":{"uri":"forgot","methods":["GET","HEAD"]},"forgot.submit":{"uri":"forgot","methods":["POST"]},"logout":{"uri":"logout","methods":["POST"]},"dashboard.index":{"uri":"dashboard","methods":["GET","HEAD"]},"my-groups.index":{"uri":"my-groups","methods":["GET","HEAD"]},"dashboard.my-groups.index":{"uri":"dashboard\/my-groups","methods":["GET","HEAD"]},"dashboard.joined-groups.index":{"uri":"dashboard\/joined-groups","methods":["GET","HEAD"]},"dashboard.account.index":{"uri":"dashboard\/account","methods":["GET","HEAD"]},"dashboard.manage-groups.index":{"uri":"dashboard\/manage-groups","methods":["GET","HEAD"]},"dashboard.manage-groups.store":{"uri":"dashboard\/manage-groups","methods":["POST"]},"dashboard.manage-groups.edit":{"uri":"dashboard\/manage-groups\/{manage_group}\/edit","methods":["GET","HEAD"],"parameters":["manage_group"]},"dashboard.manage-groups.update":{"uri":"dashboard\/manage-groups\/{manage_group}","methods":["PUT","PATCH"],"parameters":["manage_group"]},"dashboard.manage-groups.destroy":{"uri":"dashboard\/manage-groups\/{manage_group}","methods":["DELETE"],"parameters":["manage_group"]},"dashboard.manage-groups.users-suggestion":{"uri":"dashboard\/manage-template-tasks\/users-suggestion\/{id}","methods":["GET","HEAD"],"parameters":["id"]},"dashboard.manage-users.index":{"uri":"dashboard\/manage-users","methods":["GET","HEAD"]},"dashboard.manage-users.store":{"uri":"dashboard\/manage-users","methods":["POST"]},"dashboard.manage-users.edit":{"uri":"dashboard\/manage-users\/{manage_user}\/edit","methods":["GET","HEAD"],"parameters":["manage_user"]},"dashboard.manage-users.update":{"uri":"dashboard\/manage-users\/{manage_user}","methods":["PUT","PATCH"],"parameters":["manage_user"]},"dashboard.manage-users.destroy":{"uri":"dashboard\/manage-users\/{manage_user}","methods":["DELETE"],"parameters":["manage_user"]},"dashboard.system-roles-permissions.index":{"uri":"dashboard\/system-roles-permissions","methods":["GET","HEAD"]},"dashboard.system-roles-permissions.update":{"uri":"dashboard\/system-roles-permissions\/{system_roles_permission}","methods":["PUT","PATCH"],"parameters":["system_roles_permission"]},"dashboard.system-settings.index":{"uri":"dashboard\/system-settings","methods":["GET","HEAD"]},"dashboard.system-settings.update":{"uri":"dashboard\/system-settings\/{system_setting}","methods":["PUT","PATCH"],"parameters":["system_setting"]},"dashboard.manage-template-tasks.edit":{"uri":"dashboard\/manage-template-tasks\/{manage_template_task}\/edit","methods":["GET","HEAD"],"parameters":["manage_template_task"]},"dashboard.manage-template-tasks.update":{"uri":"dashboard\/manage-template-tasks\/{manage_template_task}","methods":["PUT","PATCH"],"parameters":["manage_template_task"]},"dashboard.manage-posts.index":{"uri":"dashboard\/manage-posts","methods":["GET","HEAD"]},"dashboard.manage-posts.store":{"uri":"dashboard\/manage-posts","methods":["POST"]},"dashboard.manage-posts.update":{"uri":"dashboard\/manage-posts\/{manage_post}","methods":["PUT","PATCH"],"parameters":["manage_post"]},"dashboard.manage-posts.destroy":{"uri":"dashboard\/manage-posts\/{manage_post}","methods":["DELETE"],"parameters":["manage_post"]},"dashboard.manage-comments.store":{"uri":"dashboard\/manage-comments","methods":["POST"]},"dashboard.manage-comments.destroy":{"uri":"dashboard\/manage-comments\/{manage_comment}","methods":["DELETE"],"parameters":["manage_comment"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
